<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Exception\RemoveException;

trait RemovableInterfaceTrait
{
    //<editor-fold desc="RemovableInterface methods">
    public function remove($key): CollectionInterface
    {
        if(array_key_exists($this->items, $key)){
            unset($this->items[$key]);
            $this->count--;
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