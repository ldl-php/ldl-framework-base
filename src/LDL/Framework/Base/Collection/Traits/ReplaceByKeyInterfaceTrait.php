<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 *
 * WARNING: Do not use append or remove, this may cause an infinity loop
 * Be aware when comparing objects which have other deeply nested objects, PHP could throw a Fatal Error
 * PHP Fatal error:  Nesting level too deep - recursive dependency?
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\OnReplaceNoMatchInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\HasDuplicateKeyResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\DuplicateResolverCollection;
use LDL\Framework\Base\Collection\Resolver\Contracts\DuplicateResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Key\DecimalKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\HasObjectKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\StringKeyResolver;
use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Helper\IterableHelper;

/**
 * Trait ReplaceByKeyInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see ReplaceByKeyInterface
 */
trait ReplaceByKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;

    private $_instanceOfLockableObject;
    private $_instanceOfLockReplace;

    //<editor-fold desc="ReplaceByKeyInterface Methods">
    public function replaceByKey(
        $key,
        $newKey,
        $replacement=null,
        string $operator = Constants::OPERATOR_SEQ,
        string $order = Constants::COMPARE_LTR
    ) : int
    {
        ArrayHelper::isValidKey($key);
        ArrayHelper::isValidKey($newKey);

        $this->requireImplements([
            CollectionInterface::class,
            ReplaceByKeyInterface::class
        ]);

        $this->requireTraits(CollectionInterfaceTrait::class);

        if(null === $this->_instanceOfLockableObject){
            $this->_instanceOfLockableObject = $this instanceof LockableObjectInterface;
        }

        if(null === $this->_instanceOfLockReplace){
            $this->_instanceOfLockReplace = $this instanceof LockReplaceInterface;
        }

        if($this->_instanceOfLockableObject){
            $this->checkLock();
        }

        if($this->_instanceOfLockReplace){
            $this->checkLockReplace();
        }

        $newItems = $items = IterableHelper::toArray($this, true);

        $callback = function($val, $k) use ($replacement, &$newItems, $key, $newKey, $operator, $order) {
            $compare = ComparisonOperatorHelper::compare($k, $key, $operator, $order);

            if (!$compare) {
                return false;
            }

            if ($this instanceof BeforeReplaceInterface) {
                $this->getBeforeReplace()->call(
                    $this,
                    $val,
                    $k,
                    $replacement,
                    $operator,
                    $order
                );
            }

            unset($newItems[$k]);

            if(array_key_exists($newKey, $newItems)){
                $newKey = $this->_getReplaceByKeyDuplicateKeyResolver()
                    ->resolveDuplicate($this, $newKey, $replacement);
            }

            $newItems[$newKey] = $replacement ?? $val;

            return true;
        };

        $replaced = ArrayHelper::replaceByCallback($items, null, $callback, true);

        if($replaced > 0){
            $this->setItems($newItems);

            return $replaced;
        }

        if($this instanceof OnReplaceNoMatchInterface){
            $this->getOnReplaceNoMatch()->call(...func_get_args());
        }

        return $replaced;
    }

    private function _getReplaceByKeyDuplicateKeyResolver() : DuplicateResolverInterface
    {
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