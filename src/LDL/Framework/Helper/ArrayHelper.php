<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

abstract class ArrayHelper
{
    /**
     * @param $key
     * @return bool
     */
    public static function isValidKey($key) : bool
    {
        return is_string($key) || is_int($key) || is_float($key);
    }
}