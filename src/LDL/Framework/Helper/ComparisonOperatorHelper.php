<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

abstract class ComparisonOperatorHelper
{
    public const OPERATOR_EQ='==';
    public const OPERATOR_SEQ='===';
    public const OPERATOR_GT='>';
    public const OPERATOR_GTE='>=';
    public const OPERATOR_LT='<';
    public const OPERATOR_LTE='<=';

    public static function validate(string $operator) : void
    {
        $validOperators = [
            self::OPERATOR_EQ,
            self::OPERATOR_SEQ,
            self::OPERATOR_GT,
            self::OPERATOR_GTE,
            self::OPERATOR_LT,
            self::OPERATOR_LTE
        ];

        if(in_array($operator,$validOperators, true)){
            return;
        }

        throw new \InvalidArgumentException(sprintf(
            '"%s" is not a valid comparison operator. Valid comparison operators are: "%s"',
            $operator,
            implode(', ', $validOperators)
        ));
    }

    public static function isValid(string $operator) : bool
    {
        $validOperators = [
            self::OPERATOR_EQ,
            self::OPERATOR_SEQ,
            self::OPERATOR_GT,
            self::OPERATOR_GTE,
            self::OPERATOR_LT,
            self::OPERATOR_LTE
        ];

        return in_array($operator,$validOperators, true);
    }
}