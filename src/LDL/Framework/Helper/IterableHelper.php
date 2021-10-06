<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Collection\Contracts\ComparisonInterface;
use LDL\Framework\Base\Constants;

final class IterableHelper
{
    public const BEFORE_LAST_POSITION = -2;
    public const LAST_POSITION = -1;

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
                case Constants::LDL_TYPE_UINT:
                    $hasUint = true;
                    break;

                case Constants::LDL_TYPE_UDOUBLE:
                    $hasUDouble = true;
                    break;

                case Constants::LDL_TYPE_STRNUM:
                    $hasStrNum = true;
                    break;
            }
        }

        return self::filter($items, static function ($val) use ($types, $hasUint, $hasUDouble, $hasStrNum){
            $type = strtolower(gettype($val));

            if($hasUint && Constants::PHP_TYPE_INTEGER === $type){
                return $val >= 0;
            }

            if($hasUDouble && Constants::PHP_TYPE_DOUBLE === $type){
                return $val >= 0;
            }

            if($hasStrNum && (Constants::PHP_TYPE_INTEGER === $type || Constants::PHP_TYPE_DOUBLE === $type)){
                return true;
            }

            return in_array($type, $types, true);
        });
    }

    public static function unique(iterable $items)
    {
        $values = [];

        return self::filter($items, static function($val, $key) use (&$values){
            $value = $val;
            $isObject = is_object($val);
            $isComparable = $val instanceof ComparisonInterface;

            if($isObject && !$isComparable){
                if(!method_exists($val, '__toString')){
                    return false;
                }

                $value = (string) $val;
            }

            if($isObject && $isComparable){
                $value = $val->getComparisonValue();
            }

            if(!is_scalar($value)){
                return false;
            }

            if(in_array($value, $values, true)){
                return false;
            }

            $values[$key] = $value;
            return true;
        });
    }

    public static function cast(iterable $items, string $type) : array
    {
        return self::map($items, static function($val, $key) use($type){
            $val = false === $val ? '0' : $val;

            if(is_object($val) && method_exists($val, '__toString')){
                $val = (string) $val;
            }

            switch($type){
                case Constants::LDL_TYPE_UINT:
                    $setType = Constants::PHP_TYPE_INTEGER;
                    break;
                case Constants::LDL_TYPE_UDOUBLE:
                    $setType = Constants::PHP_TYPE_DOUBLE;
                    break;
                default:
                    $setType = $type;
            }

            settype($val, $setType);

            if(Constants::LDL_TYPE_UINT === $type && $val < 0){
                $val = 0;
            }

            if(Constants::LDL_TYPE_UDOUBLE === $type && $val < 0){
                $val = 0.0;
            }

            return $val;
        });
    }
}
