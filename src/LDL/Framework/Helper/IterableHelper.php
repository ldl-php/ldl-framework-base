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

    /**
     * @param iterable $items
     *
     * @return array
     */
    public static function toArray(iterable $items) : array
    {
        if(is_array($items)){
            return $items;
        }

        if($items instanceof \Traversable){
            return \iterator_to_array($items, true);
        }

        return [];
    }

    /**
     * @param iterable $items
     * @param callable $func
     *
     * @return array
     */
    public static function map(iterable $items, callable $func) : array
    {
        return array_map($func, self::toArray($items));
    }

    /**
     * @param iterable $items
     * @param callable $func
     * @param int $mode
     *
     * @return array
     */
    public static function filter(iterable $items, callable $func, int $mode=0) : array
    {
        return array_filter(self::toArray($items), $func, $mode);
    }

}
