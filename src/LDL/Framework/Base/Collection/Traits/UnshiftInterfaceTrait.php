<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait UnshiftInterfaceTrait
{
    //<editor-fold desc="UnshiftInterface methods">
    public function unshift($item, $key = null): CollectionInterface
    {
        $key = $key ?? 0;

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