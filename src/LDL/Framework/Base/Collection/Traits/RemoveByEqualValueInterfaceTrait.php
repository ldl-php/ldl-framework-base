<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByEqualValueInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait RemoveByEqualValueInterfaceTrait
{
    use ClassRequirementHelperTrait;

    //<editor-fold desc="RemovableInterface methods">
    public function removeByEqualValue($value, bool $strict = true) : int
    {
        $this->requireImplements([
            CollectionInterface::class,
            RemoveByEqualValueInterface::class
        ]);

        $this->requireTraits([CollectionInterfaceTrait::class]);

        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockRemoveInterface){
            $this->checkLockRemove();
        }

        $removed = 0;

        foreach($this as $key => $val){
            $equals = $strict ? $val === $value : $val == $value;

            if(!$equals) {
                continue;
            }

            if($this instanceof BeforeRemoveInterface){
                $this->getBeforeRemove()->call($this, $this->get($key), $key);
            }

            $this->removeItem($key);
            $this->setCount($this->count() - 1);

            $removed++;
        }

        $keys = $this->keys();
        $lastKey = count($keys);

        if(0 === $lastKey) {
            $this->setFirstKey(null);
            $this->setLastKey(null);
            return $removed;
        }

        $this->setFirstKey($keys[0]);
        $this->setLastKey($keys[$lastKey - 1]);

        return $removed;
    }
    //</editor-fold>

}