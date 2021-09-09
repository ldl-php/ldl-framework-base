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

    public static function keys(iterable $items) : array
    {
        return array_keys(self::toArray($items));
    }

    /**
     * Maps every value inside of an iterable
     *
     * The $mapped parameter is useful when you need to know exactly how many items were modified
     *
     * @param iterable $items
     * @param callable $func
     * @param int $mapped
     *
     * @return array
     */
    public static function map(iterable $items, callable $func, int &$mapped=null) : array
    {
        $mapped = null === $mapped || $mapped <= 0 ? 0 : $mapped;

        $items = self::toArray($items);

        return array_map(static function($value, $key) use (&$func, &$mapped){
            $result = $func($value, $key);

            if($result !== $value){
                $mapped++;
            }

            return $result;
        }, array_values($items), array_keys($items));
    }

    /**
     * @param iterable $items
     * @param callable $func
     * @param int $filtered
     *
     * @return array
     */
    public static function filter(iterable $items, callable $func, int &$filtered=null) : array
    {
        $filtered = 0;

        return array_filter(
            self::toArray($items),
            static function($curVal, $curKey) use (&$func, &$filtered, &$items) : bool {
                return true === $func($curVal, $curKey, $items, $filtered) && ++$filtered;
            },
            \ARRAY_FILTER_USE_BOTH
        );
    }

}
