<?php declare(strict_types=1);

namespace LDL\Framework\Helper\ArrayHelper;

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
                'Key type must be a string, an integer or a float, %s was given',
                gettype($key)
            )
        );
    }
}