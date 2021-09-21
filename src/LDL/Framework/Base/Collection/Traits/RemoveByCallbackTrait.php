<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 *
 * WARNING: Do not use append or remove, this may cause an infinity loop
 * Be aware when comparing objects which have other deeply nested objects, PHP could throw a Fatal Error
 * PHP Fatal error:  Nesting level too deep - recursive dependency?
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\OnRemoveNoMatchInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByCallbackInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\IterableHelper;

/**
 * Trait RemoveByCallbackTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see RemoveByCallbackInterface
 */
trait RemoveByCallbackTrait
{
    use ClassRequirementHelperTrait;

    private $_instanceOfLockableObject;
    private $_instanceOfLockReplace;

    //<editor-fold desc="RemoveByCallbackInterface Methods">
    public function removeByCallback(callable $func) : int
    {
        $this->requireImplements([
            CollectionInterface::class,
            RemoveByCallbackInterface::class
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

        $items = IterableHelper::filter(
            $this,
            function ($val, $key) use ($func){
                if(false === $func($val, $key, $this)){
                    return true;
                }

                if ($this instanceof BeforeRemoveInterface) {
                    $this->getBeforeRemove()->call(
                        $this,
                        $val,
                        $key
                    );
                }

                return false;
            },
            $removed
        );

        if($removed > 0){
            $this->setItems($items);

            return $removed;
        }

        if($this instanceof OnRemoveNoMatchInterface){
            $this->getOnRemoveNoMatch()->call(...func_get_args());
        }

        return $removed;
    }
    //</editor-fold>
}