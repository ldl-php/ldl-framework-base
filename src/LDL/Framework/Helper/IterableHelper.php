<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

abstract class IterableHelper
{
    /**
     * @param iterable $items
     * @return int|null
     */
    public static function getCount(iterable $items) : ?int
    {
        if(is_array($items) || $items instanceof \Countable){
            return count($items);
        }

        return count(\iterator_to_array($items));
    }
}