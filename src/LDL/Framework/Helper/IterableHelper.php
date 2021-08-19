<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

final class IterableHelper
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
     * @param bool $useKeys
     *
     * @return array
     */
    public static function toArray(iterable $items, bool $useKeys = true) : array
    {
        if(is_array($items)){
            return $useKeys ? $items : array_values($items);
        }

        if($items instanceof \Traversable){
            return \iterator_to_array($items, $useKeys);
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
