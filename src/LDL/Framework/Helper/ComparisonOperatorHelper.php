<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

abstract class ComparisonOperatorHelper
{
    public const OPERATOR_EQ='==';
    public const OPERATOR_STR_EQ='eq';

    public const OPERATOR_SEQ='===';
    public const OPERATOR_STR_SEQ='se';

    public const OPERATOR_GT='>';
    public const OPERATOR_STR_GT='gt';

    public const OPERATOR_GTE='>=';
    public const OPERATOR_STR_GTE='gte';

    public const OPERATOR_LT='<';
    public const OPERATOR_STR_LT='lt';

    public const OPERATOR_LTE='<=';
    public const OPERATOR_STR_LTE='le';

    public static function validate(string $operator) : void
    {
        $validOperators = [
            self::OPERATOR_EQ,
            self::OPERATOR_STR_EQ,
            self::OPERATOR_SEQ,
            self::OPERATOR_STR_SEQ,
            self::OPERATOR_GT,
            self::OPERATOR_STR_GT,
            self::OPERATOR_GTE,
            self::OPERATOR_STR_GTE,
            self::OPERATOR_LT,
            self::OPERATOR_STR_LT,
            self::OPERATOR_LTE,
            self::OPERATOR_STR_LTE,
        ];

        if(in_array($operator, $validOperators, true)){
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
            self::OPERATOR_STR_EQ,
            self::OPERATOR_SEQ,
            self::OPERATOR_STR_SEQ,
            self::OPERATOR_GT,
            self::OPERATOR_STR_GT,
            self::OPERATOR_GTE,
            self::OPERATOR_STR_GTE,
            self::OPERATOR_LT,
            self::OPERATOR_STR_LT,
            self::OPERATOR_LTE,
            self::OPERATOR_STR_LTE
        ];

        return in_array($operator, $validOperators, true);
    }

    public static function isEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_EQ === $operator || self::OPERATOR_EQ === $operator;
        }

        return self::OPERATOR_EQ === $operator;
    }

    public static function isStrictlyEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_SEQ === $operator || self::OPERATOR_SEQ === $operator;
        }

        return self::OPERATOR_SEQ === $operator;

    }

    public static function isGreaterOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_GT === $operator || self::OPERATOR_GT === $operator;
        }

        return self::OPERATOR_GT === $operator;
    }

    public static function isGreaterOrEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_GTE === $operator || self::OPERATOR_GTE === $operator;
        }

        return self::OPERATOR_GTE === $operator;
    }

    public static function isLowerOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_LT === $operator || self::OPERATOR_LT === $operator;
        }

        return self::OPERATOR_LT === $operator;
    }

    public static function isLowerOrEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_LTE === $operator || self::OPERATOR_LTE === $operator;
        }

        return self::OPERATOR_LTE === $operator;
    }

}