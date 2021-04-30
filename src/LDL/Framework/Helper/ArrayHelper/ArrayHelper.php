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

    /**
     * @param array $array
     * @param $key
     * @return bool
     * @throws Exception\InvalidKeyException
     */
    public static function hasKey(array $array, $key): bool
    {
        self::validateKey($key);
        return array_key_exists($key, $array);
    }

    /**
     * @param array $array
     * @param $key
     * @throws Exception\InvalidKeyException
     * @throws \RuntimeException
     */
    public static function mustHaveKey(array $array, $key): void
    {
        $hasKey = self::hasKey($array, $key);

        if($hasKey){
            return;
        }

        $msg = sprintf("Key: %s does not exist", $key);
        throw new \RuntimeException($msg);
    }
}