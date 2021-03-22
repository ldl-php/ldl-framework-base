<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;

trait RemovableInterfaceTrait
{
    /**
     * @var iterable|callable|null
     */
    private $_tBeforeRemoveCallback;

    //<editor-fold desc="RemovableInterface methods">
    public function onBeforeRemove($item, $key): void
    {
        if(null === $this->_tBeforeRemoveCallback){
            return;
        }

        array_map(function($callback) use ($item, $key){
            if(is_callable($callback)) {
                $callback($this, $item, $key);
            }
        }, is_iterable($this->_tBeforeRemoveCallback) ? $this->_tBeforeRemoveCallback : [$this->_tBeforeRemoveCallback]);
    }

    public function remove($key): CollectionInterface
    {
        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockRemoveInterface){
            $this->checkLockRemove();
        }

        $exists = array_key_exists($key, $this->items);

        $this->onBeforeRemove($exists ? $this->items[$key] : null, $key);

        if($exists){
            unset($this->items[$key]);
            $this->count--;
            return $this;
        }

        throw new RemoveException("Item with key: $key does not exists");
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