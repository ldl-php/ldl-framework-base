<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Exception\InvalidKeyException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper;

trait AppendableInterfaceTrait
{
    /**
     * @var iterable|callable|null
     */
    private $_tBeforeAppendCallback;

    //<editor-fold desc="AppendableInterface methods">
    public function onBeforeAppend($item, $key = null): void
    {
        if(null === $this->_tBeforeAppendCallback){
            return;
        }

        array_map(function($callback) use ($item, $key){
            if(is_callable($callback)) {
                $callback($this, $item, $key);
            }
        }, is_iterable($this->_tBeforeAppendCallback) ? $this->_tBeforeAppendCallback : [$this->_tBeforeAppendCallback]);
    }

    public function append($item, $key = null): CollectionInterface
    {
        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockAppendInterface){
            $this->checkLockAppend();
        }

        if(null !== $key && false === ArrayHelper::isValidKey($key)){
            $msg = sprintf(
                'Key must be of type scalar, "%s" given',
                gettype($key)
            );

            throw new InvalidKeyException($msg);
        }

        $key = $key ?? $this->count;

        $this->onBeforeAppend($item, $key);

        if(null === $this->first){
            $this->first = $key;
        }

        $this->last = $key;

        $this->items[$key] = $item;
        $this->count++;

        return $this;
    }
    //</editor-fold>
}