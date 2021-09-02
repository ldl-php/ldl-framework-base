<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts\HasDuplicateKeyResolverInterface;
use LDL\Framework\Base\Collection\Key\Resolver\FloatKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts\HasKeyResolverInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts\HasAppendKeyResolverInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollection;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\ObjectKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\StringKeyResolver;
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

        $keyResolver = $this->_getAppendKeyResolver();
        $duplicateKeyResolver = $this->_getAppendDuplicateKeyResolver();

        $key = $keyResolver->resolve($this, $key, $item);

        /**
         * If the key exists, call Duplicate key resolver
         */
        if($this->hasKey($key)) {

            $key = $duplicateKeyResolver->resolve($this, $key, $item);

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

        $this->increaseAutoIncrement();

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
    private function _getAppendKeyResolver() : KeyResolverCollectionInterface
    {
        if($this instanceof HasAppendKeyResolverInterface){
            return $this->getAppendKeyResolver();
        }

        if($this instanceof HasKeyResolverInterface){
            return $this->getKeyResolver();
        }

        return new KeyResolverCollection([
            new IntegerKeyResolver(),
            new FloatKeyResolver(),
            new StringKeyResolver(),
            new ObjectKeyResolver()
        ]);
    }

    private function _getAppendDuplicateKeyResolver() : KeyResolverCollectionInterface
    {
        if($this instanceof HasDuplicateKeyResolverInterface){
            return $this->getDuplicateKeyResolver();
        }

        return new KeyResolverCollection([
            new StringKeyResolver(),
            new IntegerKeyResolver()
        ]);
    }
    //</editor-fold>
}