<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;

trait TruncateInterfaceTrait
{
    //<editor-fold desc="TruncateInterface methods">
    public function truncate() : CollectionInterface
    {
        if($this instanceof LockableObjectInterface){
            $this->checkLock();
        }

        if($this instanceof LockRemoveInterface){
            $this->checkLockRemove();
        }
        foreach($this as $key => $item) {
            $this->onBeforeRemove($item, $key);
        }

        $collection = clone $this;
        $collection->items = [];
        $collection->first = null;
        $collection->last = null;
        $collection->count = 0;

        return $collection;
    }
    //</editor-fold>
}