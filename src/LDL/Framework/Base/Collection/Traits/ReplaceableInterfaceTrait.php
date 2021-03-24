<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Exception\ReplaceException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;

trait ReplaceableInterfaceTrait
{
    public function replace($item, $key) : CollectionInterface
    {
        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockReplaceInterface){
            $this->checkLockReplace();
        }

        if(null !== $key){
            ArrayHelper::validateKey($key);
        }

        if($this instanceof BeforeReplaceInterface){
            $this->getBeforeReplace()->call($this, $item, $key);
        }

        if(false === array_key_exists($key, $this->items)){
            if($this instanceof AppendableInterface){
                return $this->append($item, $key);
            }

            throw new ReplaceException("Item with key: $key does not exists");
        }

        $this->items[$key] = $item;

        return $this;
    }
    //</editor-fold>
}