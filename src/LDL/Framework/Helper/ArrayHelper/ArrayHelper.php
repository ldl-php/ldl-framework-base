<?php declare(strict_types=1);

namespace LDL\Framework\Helper\ArrayHelper;

use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Helper\IterableHelper;

final class ArrayHelper
{
    /**
     * @param $key
     * @return bool
     */
    public static function isValidKey($key) : bool
    {
        return is_string($key) || is_int($key);
    }

    /**
     * @param $key
     * @throws Exception\InvalidKeyException
     */
    public static function validateKey($key) : void
    {
        if (self::isValidKey($key)){
            return;
        }

        throw new Exception\InvalidKeyException(
            sprintf(
                'Key type must be a string or an integer, %s was given',
                gettype($key)
            )
        );
    }

    /**
     * @param array $array
     * @param string|int $key
     * @param string $operator
     * @param string $order
     * @return int
     * @throws Exception\InvalidKeyException
     */
    public static function hasKey(
        array $array,
        $key,
        string $operator=ComparisonOperatorHelper::OPERATOR_SEQ,
        string $order=ComparisonOperatorHelper::COMPARE_LTR
    ): int
    {
        self::validateKey($key);

        if(ComparisonOperatorHelper::isStrictlyEqualsOperator($operator)) {
            return (int) array_key_exists($key, $array);
        }

        return count(
            IterableHelper::filter($array, static function($v, $k) use ($key, $operator, $order) : bool {
                return ComparisonOperatorHelper::compare($k, $key, $operator, $order);
            }, )
        );
    }

    /**
     * @param array $array
     * @param mixed $value
     * @param string $operator
     * @param string $order
     * @return int
     */
    public static function hasValue(
        array $array,
        $value,
        string $operator=ComparisonOperatorHelper::OPERATOR_SEQ,
        string $order=ComparisonOperatorHelper::COMPARE_LTR
    ): int
    {
        return count(
            IterableHelper::filter($array, static function($v, $k) use ($value, $operator, $order) : bool {
                return ComparisonOperatorHelper::compare($v, $value, $operator, $order);
            })
        );
    }

    /**
     * Replaces values in an array through a comparison callback using a $replacement
     *
     * NOTE: This method is not part of IterableHelper since it takes an array by reference, iterable type hint
     * can not be passed by reference.
     *
     * @param array $items (By reference)
     * @param $replacement
     * @param callable $comparisonFunc
     * @param bool $useKeys
     *
     * @return int amount of items replaced
     */
    public static function replaceByCallback(
        array &$items,
        $replacement,
        callable $comparisonFunc,
        bool $useKeys=true
    ) : int
    {
        $result = IterableHelper::map(
            $items,
            static function($curVal, $curKey) use ($comparisonFunc, $replacement, &$items){
                return false === $comparisonFunc($curVal, $curKey, $replacement, $items) ? $curVal : $replacement;
            },
            $replaced
        );

        $items = $useKeys ? array_combine(IterableHelper::keys($items), $result) : $result;

        return $replaced;
    }

    /**
     * Removes values in an array through a comparison callback
     *
     * NOTE: This method is not part of IterableHelper since it takes an array by reference, iterable type hint
     * can not be passed by reference.
     *
     * @param array $items (By reference)
     * @param callable $func
     *
     * @return int amount of items removed
     */
    public static function removeByCallback(
        array &$items,
        callable $func
    ) : int
    {
        $removed = 0;

        $items = IterableHelper::filter($items, $func, $removed);

        return $removed;
    }

    /**
     * @param array $array
     * @param string|int $key
     * @param string $order
     * @param string $operator
     * @throws Exception\InvalidKeyException
     * @throws \RuntimeException
     */
    public static function mustHaveKey(
        array $array,
        $key,
        string $operator=ComparisonOperatorHelper::OPERATOR_SEQ,
        string $order=ComparisonOperatorHelper::COMPARE_LTR
    ): void
    {
        $hasKey = self::hasKey($array, $key, $operator, $order);

        if($hasKey > 0){
            return;
        }

        $msg = sprintf("Key: %s does not exist", $key);
        throw new \RuntimeException($msg);
    }
}