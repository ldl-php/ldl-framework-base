<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeResolveKeyInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\Append\HasAppendDuplicateKeyResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\HasNullKeyResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\HasValueResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\DuplicateResolverCollection;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\HasCustomKeyResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\HasDuplicateKeyResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\NullResolverCollection;
use LDL\Framework\Base\Collection\Resolver\Contracts\CustomResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Contracts\DuplicateResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Contracts\NullResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Key\DecimalKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\HasObjectKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\StringKeyResolver;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait AppendableInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var bool
     */
    private $_instanceOfLockableObject;

    /**
     * @var bool
     */
    private $_instanceOfLockAppend;

    //<editor-fold desc="AppendableInterface methods">
    public function append($item, $key = null): CollectionInterface
    {
        $this->requireImplements([AppendableInterface::class, CollectionInterface::class]);
        $this->requireTraits(CollectionInterfaceTrait::class);

        if(null === $this->_instanceOfLockableObject){
            $this->_instanceOfLockableObject = $this instanceof LockableObjectInterface;
        }

        if(null === $this->_instanceOfLockAppend){
            $this->_instanceOfLockAppend = $this instanceof LockAppendInterface;
        }

        if($this->_instanceOfLockableObject){
            $this->checkLock();
        }

        if($this->_instanceOfLockAppend){
            $this->checkLockAppend();
        }

        if($this instanceof BeforeResolveKeyInterface){
            $this->getBeforeResolveKey()->callByRef($this, $item, $key);
        }

        /**
         * If there is a custom key resolver, then the key is determined by said resolver
         */
        $customKeyResolver = $this->_getCustomKeyResolver();

        if(null !== $customKeyResolver){
            $key = $customKeyResolver->resolveCustom($this, $key, $item);
        }

        /**
         * If the specified $key is null or the $key obtained by the custom key resolver is nulll
         * then try to determine a key through the null key resolver
         */
        if(null === $key){
            $key = $this->_getAppendNullKeyResolver()
                ->resolveNull($this, $item);
        }

        /**
         * If the key exists, try to resolve a non-conflicting key through duplicate key resolvers
         */
        if($this->hasKey($key)) {
            $key = $this->_getAppendDuplicateKeyResolver()
                ->resolveDuplicate($this, $key, $item);

            /**
             * If the key still exists, throw an exception
             */
            if ($this->hasKey($key)) {

                $msg = sprintf(
                    'Item with key: %s already exists, if you want to replace an item use %s',
                    $key,
                    ReplaceByKeyInterface::class
                );

                throw new \LogicException($msg);
            }
        }

        if($this instanceof BeforeAppendInterface){
            $this->getBeforeAppend()->call($this, $item, $key);
        }

        if(null === $this->getFirstKey()){
            $this->setFirstKey($key);
        }

        $this->setLastKey($key);
        $this->setItem($item, $key);
        $this->setCount($this->count() + 1);

        return $this;
    }
    //</editor-fold>

    //<editor-fold desc="Private methods">

    private function _getCustomKeyResolver() : ?CustomResolverInterface
    {
        if($this instanceof HasCustomKeyResolverInterface){
            return $this->getCustomKeyResolver();
        }

        return null;
    }

    private function _getAppendNullKeyResolver() : NullResolverInterface
    {
        if($this instanceof HasNullKeyResolverInterface){
            return $this->getNullKeyResolver();
        }

        return new NullResolverCollection([
            new IntegerKeyResolver()
        ]);
    }

    private function _getAppendDuplicateKeyResolver() : DuplicateResolverInterface
    {
        if($this instanceof HasAppendDuplicateKeyResolverInterface){
            return $this->getAppendDuplicateKeyResolver();
        }

        if($this instanceof HasDuplicateKeyResolverInterface){
            return $this->getDuplicateKeyResolver();
        }

        return new DuplicateResolverCollection([
            new IntegerKeyResolver(),
            new DecimalKeyResolver(),
            new StringKeyResolver(),
            new HasObjectKeyResolver()
        ]);
    }
    //</editor-fold>
}