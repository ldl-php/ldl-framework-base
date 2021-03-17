<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

abstract class RegexHelper
{
    /**
     * Validates that a regex has proper delimiters
     *
     * @param string $regex
     * @throws \LogicException if the regex is invalid
     */
    public static function validate(string $regex) : void
    {
        $split = str_split($regex);
        $firstCharacter = $split[0];
        $lastCharacter = $split[count($split)-1];

        if($firstCharacter !== $lastCharacter){
            throw new \LogicException("Invalid regex: \"$regex\" no regex delimiters were found");
        }
    }
}