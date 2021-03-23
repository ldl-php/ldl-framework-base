<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Exception\InvalidKeyException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Helper\ArrayHelper;

trait UnshiftInterfaceTrait
{
    //<editor-fold desc="UnshiftInterface methods">
    public function unshift($item, $key = null): CollectionInterface
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

        $key = $key ?? 0;

        if($this instanceof BeforeAppendInterface){
            $this->getBeforeAppend()->call($this, $item, $key);
        }

        $this->first = $key;

        if(null === $this->last) {
            $this->last = $key;
        }

        if(is_string($key)){
            $this->items = [$key => $item] + $this->items;
            return $this;
        }

        $result = [$key=>$item];

        array_walk($this->items, static function($v, $k) use ($result){
            if(is_int($k)){
                ++$k;
            }

            $result[$k] = $v;
        });

        $this->items = $result;

        return $this;
    }
    //</editor-fold>
}