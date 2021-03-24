<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;

trait RemovableInterfaceTrait
{
    //<editor-fold desc="RemovableInterface methods">
    public function remove($key): CollectionInterface
    {
        ArrayHelper::validateKey($key);

        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockRemoveInterface){
            $this->checkLockRemove();
        }

        $exists = array_key_exists($key, $this->items);

        if($this instanceof BeforeRemoveInterface){
            $this->getBeforeRemove()->call($exists ? $this->items[$key] : null, $key);
        }

        if(false === $exists){
            throw new RemoveException("Item with key: $key does not exists");
        }

        unset($this->items[$key]);
        $this->count--;

        $keys = $this->keys();
        $lastKey = count($keys);

        if(0 === $lastKey) {
            $this->first = null;
            $this->last = null;
            return $this;
        }

        $this->first = $keys[0];
        $this->last = $keys[$lastKey - 1];
        return $this;
    }

    public function removeLast() : CollectionInterface
    {
        $this->remove($this->last);
        return $this;
    }

    public function removeByValue($value, bool $strict = true) : int
    {
        $removed = 0;

        foreach($this as $key => $val){
            if(true === $strict && $val === $value){
                $this->remove($key);
                $removed++;
                continue;
            }

            if($val == $value){
                $this->remove($key);
                $removed++;
            }
        }

        return $removed;
    }
    //</editor-fold>

}