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
use LDL\Framework\Base\Collection\Contracts\ReplaceByCallbackInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;

/**
 * Trait ReplaceByCallbackTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see ReplaceByCallbackInterface
 */
trait ReplaceByCallbackTrait
{
    use ClassRequirementHelperTrait;

    private $_instanceOfLockableObject;
    private $_instanceOfLockReplace;

    //<editor-fold desc="ReplaceByValueInterface Methods">
    public function replaceByCallback(callable $func, $replacement, bool $useKeys=true) : int
    {
        $this->requireImplements([
            CollectionInterface::class,
            ReplaceByCallbackInterface::class
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

        $items = IterableHelper::toArray($this, $useKeys);

        $callback = function ($val, $key) use ($func, $replacement){
            if(false === $func($val, $key)){
                return false;
            }

            if ($this instanceof BeforeReplaceInterface) {
                $this->getBeforeReplace()->call(
                    $this,
                    $val,
                    $key,
                    $replacement
                );
            }

            return true;
        };

        $replaced = ArrayHelper::replaceByCallback($items, $replacement, $callback, $useKeys);

        if($replaced > 0){
            $this->setItems($items);

            return $replaced;
        }

        if($this instanceof OnReplaceNoMatchInterface){
            $this->getOnReplaceNoMatch()->call(...func_get_args());
        }

        return $replaced;
    }
    //</editor-fold>
}