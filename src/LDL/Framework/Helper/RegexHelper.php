<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Exception\LogicException;
final class RegexHelper
{
    /**
     * Validates that a regex is valid
     *
     * @param string $regex
     * @throws LogicException if the regex is invalid
     */
    public static function validate(string $regex) : void
    {
        if(@preg_match($regex, '') === false){
            throw new LogicException("Invalid regex: \"$regex\"");
        }
    }
}