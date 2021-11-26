<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Exception\RuntimeException;
use LDL\Framework\Base\Exception\InvalidArgumentException;

final class MbEncodingHelper
{
    /**
     * @var bool
     */
    private static $hasMbString;

    /**
     * @var ?array
     */
    private static $list;

    /**
     * @param string $encoding
     * @throws RuntimeException if PHP mb extension is not present
     * @return bool
     */
    public static function isValid(string $encoding) : bool
    {
        return in_array($encoding, self::getEncodingList(), true);
    }

    /**
     * @param string $encoding
     * @throws RuntimeException if PHP mb extension is not present
     * @throws InvalidArgumentException
     */
    public static function validate(string $encoding) : void
    {
        if(!self::isValid($encoding)){
            throw new InvalidArgumentException("Invalid encoding specified: $encoding");
        }
    }

    /**
     * @return array
     */
    public static function getEncodingList() : array
    {
        if(null === self::$hasMbString){
            self::$hasMbString = function_exists('mb_list_encodings');
        }

        if(!self::$hasMbString){
            throw new RuntimeException('PHP mb extension is not present in your php install!');
        }

        if(null === self::$list){
            self::$list = \mb_list_encodings();
        }

        return self::$list;
    }
}