<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\ReplaceException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper;

trait ReplaceableInterfaceTrait
{
    /**
     * @var callable|null
     */
    private $_tBeforeReplaceCallback;

    //<editor-fold desc="ReplaceableInterface methods">
    public function onBeforeReplace($item, $key): void
    {
        if(null === $this->_tBeforeReplaceCallback){
            return;
        }

        ($this->_tBeforeReplaceCallback)($this, $item, $key);
    }

    public function replace($item, $key) : CollectionInterface
    {
        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockReplaceInterface){
            $this->checkLockReplace();
        }

        if(false === ArrayHelper::isValidKey($key)){
            $msg = sprintf(
                'Key must be of type scalar, "%s" given',
                gettype($key)
            );

            throw new InvalidKeyException($msg);
        }

        $this->onBeforeReplace($item, $key);

        if(false === array_key_exists($key, $this->items)){
            throw new ReplaceException("Item with key: $key does not exists");
        }

        $this->items[$key] = $item;
        return $this;
    }
    //</editor-fold>
}