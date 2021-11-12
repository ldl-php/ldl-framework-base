<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\ComparisonInterface;
use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Contracts\Type\ToArrayInterface;
use LDL\Framework\Base\Contracts\Type\ToBooleanInterface;
use LDL\Framework\Base\Contracts\Type\ToDoubleInterface;
use LDL\Framework\Base\Contracts\Type\ToIntegerInterface;
use LDL\Framework\Base\Contracts\Type\ToNumericInterface;
use LDL\Framework\Base\Contracts\Type\ToScalarInterface;
use LDL\Framework\Base\Contracts\Type\ToStringInterface;

final class IterableHelper
{
    public const BEFORE_LAST_POSITION = -2;
    public const LAST_POSITION = -1;

    /**
     * @param iterable|ToArrayInterface $items
     * @return int|null
     */
    public static function getCount($items) : ?int
    {
        if(is_array($items) || $items instanceof \Countable){
            return count($items);
        }

        if($items instanceof ToArrayInterface){
            return count($items->toArray());
        }

        return null;
    }

    /**
     * @param iterable|ToArrayInterface $items
     * @param bool $useKeys
     *
     * @return array
     */
    public static function toArray($items, bool $useKeys = true) : array
    {
        if($items instanceof ToArrayInterface) {
            $items = $items->toArray();
        }

        if(is_array($items)){
            return $useKeys ? $items : array_values($items);
        }

        if($items instanceof \Traversable){
            return \iterator_to_array($items, $useKeys);
        }

        return [];
    }

    /**
     * @param iterable|ToArrayInterface $items
     * @return array
     */
    public static function keys($items) : array
    {
        return array_keys(self::toArray($items));
    }

    /**
     * Maps every value inside of an iterable
     *
     * The $mapped parameter is useful when you need to know exactly how many items were modified
     *
     * @param iterable|ToArrayInterface $items
     * @param callable $func A function which maps the value
     * @param bool $preserveKeys To preserve original keys or not to
     * @param int &$modified A variable which is modified by reference stating the count of items which have been modified
     * @param callable $isModified A callable which determines if the new mapped value is different from the original value
     *
     * @return array
     */
    public static function map(
        $items,
        callable $func,
        bool $preserveKeys=true,
        int &$modified=null,
        callable $isModified=null
    ) : array
    {
        $modified = null === $modified || $modified <= 0 ? 0 : $modified;

        if(null === $isModified){
            $isModified = static function($new, $old) : bool {
              return $new !== $old;
            };
        }

        $i = $items;
        $items = self::toArray($items, $preserveKeys);
        $keys = array_keys($items);

        $map = array_map(static function($value, $key) use (&$func, &$isModified, &$modified, &$i){
            $result = $func($value, $key, $i);

            true === $isModified($result, $value, $key, $i) && $modified++;

            return $result;
        }, array_values($items), $keys);

        return $preserveKeys ? array_combine($keys, $map) : $map;
    }

    /**
     * @param iterable|ToArrayInterface $items
     * @param callable $func
     * @param int $filtered
     *
     * @return array
     */
    public static function filter($items, callable $func, int &$filtered=null) : array
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
     * @param iterable|ToArrayInterface $items
     * @param int $position
     * @return mixed
     */
    public static function getKeyInPosition($items, int $position)
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

    /**
     * @param iterable|ToArrayInterface $items
     * @param string $type
     * @return array
     */
    public static function filterByValueType($items, string $type) : array
    {
        return self::filterByValueTypes($items, [$type]);
    }

    /**
     * @param iterable|ToArrayInterface $items
     * @param iterable $types
     * @return array
     */
    public static function filterByValueTypes($items, iterable $types) : array
    {
        $types = self::toArray($types);

        $hasUint = $hasUDouble = $hasNumeric = $hasUNumeric = $hasScalar = false;

        foreach($types as $type){
            switch(strtolower($type)){
                case Constants::LDL_TYPE_UINT:
                    $hasUint = true;
                    break;

                case Constants::LDL_TYPE_UDOUBLE:
                    $hasUDouble = true;
                    break;

                case Constants::LDL_TYPE_NUMERIC:
                    $hasNumeric = true;
                    break;

                case Constants::LDL_TYPE_UNUMERIC:
                    $hasUNumeric = true;
                    break;

                case Constants::LDL_TYPE_SCALAR:
                    $hasScalar = true;
                    break;
            }
        }

        return self::filter($items, static function ($val) use ($types, $hasUint, $hasUDouble, $hasNumeric, $hasUNumeric, $hasScalar){
            $type = strtolower(gettype($val));

            $isObject = Constants::PHP_TYPE_OBJECT === $type;
            $_types[$type] = $val;

            if($isObject && $val instanceof ToIntegerInterface){
                $_types[Constants::PHP_TYPE_INTEGER] = $val->toInteger();
            }

            if($isObject && $val instanceof ToDoubleInterface){
                $_types[Constants::PHP_TYPE_DOUBLE] = $val->toDouble();
            }

            if($isObject && $val instanceof ToArrayInterface){
                $_types[Constants::PHP_TYPE_ARRAY] = $val->toArray();
            }

            if($isObject && $val instanceof ToNumericInterface){
                $_types[Constants::LDL_TYPE_NUMERIC] = $val->toNumeric();
            }

            if($isObject && $val instanceof ToScalarInterface){
                $_types[Constants::LDL_TYPE_SCALAR] = $val->toScalar();
            }

            if($isObject && $val instanceof ToStringInterface){
                $_types[Constants::PHP_TYPE_STRING] = $val->toString();
            }

            if($isObject && $val instanceof ToBooleanInterface){
                $_types[Constants::PHP_TYPE_BOOL] = $val->toBoolean();
            }

            if($hasUint && array_key_exists(Constants::PHP_TYPE_INTEGER, $_types)){
                return $_types[Constants::PHP_TYPE_INTEGER] >= 0;
            }

            if($hasUDouble && array_key_exists(Constants::PHP_TYPE_DOUBLE, $_types)){
                return $_types[Constants::PHP_TYPE_DOUBLE] >= 0;
            }

            if(
                $hasNumeric &&
                is_numeric(
                    array_key_exists(Constants::LDL_TYPE_NUMERIC, $_types) ? $_types[Constants::LDL_TYPE_NUMERIC] : $val
                )
            ){
                return true;
            }

            if(
                $hasUNumeric &&
                is_numeric(
                    array_key_exists(Constants::LDL_TYPE_NUMERIC, $_types) ? $_types[Constants::LDL_TYPE_NUMERIC] : $val
                ) &&
                (array_key_exists(Constants::LDL_TYPE_NUMERIC, $_types) ? $_types[Constants::LDL_TYPE_NUMERIC] : $val) > 0
            ){
                return true;
            }

            if($hasScalar && is_scalar(
                array_key_exists(Constants::LDL_TYPE_SCALAR, $_types) ? $_types[Constants::LDL_TYPE_SCALAR] : $val)
            ){
                return true;
            }

            foreach($types as $t){
                if(array_key_exists($t, $_types)){
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * Checks if $items is_iterable or if $items is an instance of ToArrayInterface
     *
     * @param mixed $items
     * @return bool
     */
    public static function isIterable($items) : bool
    {
        return is_iterable($items) || $items instanceof ToArrayInterface;
    }

    /**
     * @param iterable|ToArrayInterface $items
     * @param array|null $values
     * @return array
     */
    public static function unique($items, array &$values=null) : array
    {
        if(null === $values) {
            $values = [];
        }

        if(is_object($items) && $items instanceof ComparisonInterface){
            $val = $items->getComparisonValue();
            return self::unique(self::isIterable($val) ? $val : [$val], $values);
        }

        $items = self::isIterable($items) ? self::toArray($items) : [$items];

        foreach($items as $item){
            if(is_iterable($item)){
                self::unique($item, $values);
                continue;
            }

            if (!in_array($item, $values, true)) {
                $values[] = $item;
            }

        }

        return $values;
    }

    /**
     * @param iterable|ToArrayInterface $items
     * @param string $type
     * @return array
     */
    public static function cast($items, string $type) : array
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
