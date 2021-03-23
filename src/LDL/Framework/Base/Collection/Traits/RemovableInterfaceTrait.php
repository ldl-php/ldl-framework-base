<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper;

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

        if(false === ArrayHelper::isValidKey($key)){
            $msg = sprintf(
                'Key must be of type scalar, "%s" given',
                gettype($key)
            );

            throw new InvalidKeyException($msg);
        }

        $exists = array_key_exists($key, $this->items);

        $this->onBeforeRemove($exists ? $this->items[$key] : null, $key);

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