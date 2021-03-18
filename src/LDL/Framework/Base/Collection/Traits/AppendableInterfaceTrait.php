<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait AppendableInterfaceTrait
{
    //<editor-fold desc="AppendableInterface methods">
    public function append($item, $key = null): CollectionInterface
    {
        $key = $key ?? $this->count;

        if(null === $this->first){
            $this->first = $key;
        }

        $this->last = $key;

        $this->items[$key] = $item;
        $this->count++;

        return $this;
    }

    public function appendMany(iterable $items, bool $useKey=false) : CollectionInterface
    {
        foreach ($items as $key => $value) {
            $this->append($value, $useKey ? $key : null);
        }

        return $this;
    }
    //</editor-fold>
}