<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Exception\ReplaceException;

trait ReplaceableInterfaceTrait
{
    //<editor-fold desc="ReplaceableInterface methods">
    public function replace($item, $key) : CollectionInterface
    {
        if(false === array_key_exists($key, $this->items)){
            throw new ReplaceException("Item with key: $key does not exists");
        }

        $this->items[$key] = $item;
        return $this;
    }
    //</editor-fold>
}