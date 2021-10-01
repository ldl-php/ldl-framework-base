<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

final class IterableHelper
{
    public const BEFORE_LAST_POSITION = -2;
    public const LAST_POSITION = -1;

    public const PHP_TYPE_STRING = 'string';
    public const PHP_TYPE_BOOL = 'boolean';
    public const PHP_TYPE_ARRAY = 'array';
    public const PHP_TYPE_INTEGER = 'integer';
    public const PHP_TYPE_DOUBLE = 'double';
    public const PHP_TYPE_OBJECT = 'object';
    public const PHP_TYPE_RESOURCE = 'resource';
    public const PHP_TYPE_NULL = 'null';

    public const LDL_TYPE_STRNUM = 'strnum';
    public const LDL_TYPE_UINT = 'uint';
    public const LDL_TYPE_UDOUBLE = 'udouble';

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

    /**
     * @param iterable $items
     * @param int $position
     * @return mixed
     */
    public static function getKeyInPosition(iterable $items, int $position)
    {
        $keys = self::keys($items);
        $pos = $position < 0 ? count($keys) + $position : $position;

        if(!array_key_exists($pos, $keys)){
            $msg = sprintf(
                'Position "%s" is undefined',
                $position
            );

            throw new \InvalidArgumentException($msg);
        }

        return $keys[$pos];
    }

    public static function filterByValueType(iterable $items, string $type) : array
    {
        return self::filterByValueTypes($items, [$type]);
    }

    public static function filterByValueTypes(iterable $items, iterable $types) : array
    {
        $types = self::toArray($types);

        $hasUint = $hasUDouble = $hasStrNum = false;

        foreach($types as $type){
            switch(strtolower($type)){
                case self::LDL_TYPE_UINT:
                    $hasUint = true;
                break;

                case self::LDL_TYPE_UDOUBLE:
                    $hasUDouble = true;
                break;

                case self::LDL_TYPE_STRNUM:
                    $hasStrNum = true;
                break;
            }
        }

        return self::filter($items, static function ($val) use ($types, $hasUint, $hasUDouble, $hasStrNum){
            $type = strtolower(gettype($val));

            if($hasUint && self::PHP_TYPE_INTEGER === $type){
                return $val >= 0;
            }

            if($hasUDouble && self::PHP_TYPE_DOUBLE === $type){
                return $val >= 0;
            }

            if($hasStrNum && (self::PHP_TYPE_INTEGER === $type || self::PHP_TYPE_DOUBLE === $type)){
                return true;
            }

            return in_array($type, $types, true);
        });
    }
}
