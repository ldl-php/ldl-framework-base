<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

abstract class ComparisonOperatorHelper
{
    public const OPERATOR_EQ='==';
    public const OPERATOR_STR_EQ='eq';

    public const OPERATOR_NOT_EQ='!=';
    public const OPERATOR_STR_NOT_EQ='ne';

    public const OPERATOR_SEQ='===';
    public const OPERATOR_STR_SEQ='se';

    public const OPERATOR_NOT_SEQ='!==';
    public const OPERATOR_STR_NOT_SEQ='nse';

    public const OPERATOR_GT='>';
    public const OPERATOR_STR_GT='gt';

    public const OPERATOR_GTE='>=';
    public const OPERATOR_STR_GTE='gte';

    public const OPERATOR_LT='<';
    public const OPERATOR_STR_LT='lt';

    public const OPERATOR_LTE='<=';
    public const OPERATOR_STR_LTE='le';

    public static function getValidOperators() : array
    {
        return [
            self::OPERATOR_EQ,
            self::OPERATOR_STR_EQ,
            self::OPERATOR_NOT_EQ,
            self::OPERATOR_STR_NOT_EQ,
            self::OPERATOR_SEQ,
            self::OPERATOR_STR_SEQ,
            self::OPERATOR_NOT_SEQ,
            self::OPERATOR_STR_NOT_SEQ,
            self::OPERATOR_GT,
            self::OPERATOR_STR_GT,
            self::OPERATOR_GTE,
            self::OPERATOR_STR_GTE,
            self::OPERATOR_LT,
            self::OPERATOR_STR_LT,
            self::OPERATOR_LTE,
            self::OPERATOR_STR_LTE
        ];
    }

    /**
     * @param string $operator
     * @throws \InvalidArgumentException
     */
    public static function validate(string $operator) : void
    {
        if(self::isValid($operator)){
            return;
        }

        throw new \InvalidArgumentException(sprintf(
            '"%s" is not a valid comparison operator. Valid comparison operators are: "%s"',
            $operator,
            implode(', ', self::getValidOperators())
        ));
    }

    public static function isValid(string $operator) : bool
    {
        return in_array($operator, self::getValidOperators(), true);
    }

    /**
     * @TODO Consider using PHP assert (only when upgrading to 8, suggested by Levy Morrison from PHP Core)
     *
     * @param mixed $a
     * @param mixed $b
     * @param string $operator
     * @throws \InvalidArgumentException if given $operator is invalid
     * @return bool
     */
    public static function compare($a, $b, $operator) : bool
    {
        self::validate($operator);

        switch($operator){
            case self::isEqualsOperator($operator):
                return $a == $b;
            break;

            case self::isStrictlyEqualsOperator($operator):
                return $a === $b;
            break;

            case self::isNotEqualsOperator($operator):
                return $a != $b;
            break;

            case self::isStrictlyNotEqualsOperator($operator):
                return $a !== $b;
            break;

            case self::isGreaterOperator($operator):
                return $a > $b;
            break;

            case self::isGreaterOrEqualsOperator($operator):
                return $a >= $b;
            break;

            case self::isLowerOperator($operator):
                return $a < $b;
            break;

            case self::isLowerOrEqualsOperator($operator):
                return $a <= $b;
            break;
        }

        /**
         * Not needed, all cases above plus operator validation must ensure operator
         */
        return false;
    }

    /**
     * @TODO Consider using PHP assert (only when upgrading to 8, suggested by Levy Morrison from PHP Core)
     *
     * @param mixed $a
     * @param mixed $b
     * @param string $operator
     * @throws \InvalidArgumentException if given $operator is invalid
     * @return bool
     */
    public static function compareInverse($a, $b, $operator) : bool
    {
        self::validate($operator);

        switch($operator){
            case self::isEqualsOperator($operator):
                return $a != $b;
                break;

            case self::isStrictlyEqualsOperator($operator):
                return $a !== $b;
                break;

            case self::isNotEqualsOperator($operator):
                return $a == $b;
                break;

            case self::isStrictlyNotEqualsOperator($operator):
                return $a === $b;
                break;

            case self::isGreaterOperator($operator):
                return $a < $b;
                break;

            case self::isGreaterOrEqualsOperator($operator):
                return $a <= $b;
                break;

            case self::isLowerOperator($operator):
                return $a > $b;
                break;

            case self::isLowerOrEqualsOperator($operator):
                return $a >= $b;
                break;
        }

        /**
         * Not needed, all cases above plus operator validation must ensure operator
         */
        return false;
    }

    public static function isEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_EQ === $operator || self::OPERATOR_EQ === $operator;
        }

        return self::OPERATOR_EQ === $operator;
    }

    public static function isNotEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_NOT_EQ === $operator || self::OPERATOR_STR_NOT_SEQ === $operator;
        }

        return self::OPERATOR_STR_NOT_EQ === $operator;
    }

    public static function isStrictlyEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_SEQ === $operator || self::OPERATOR_SEQ === $operator;
        }

        return self::OPERATOR_SEQ === $operator;
    }

    public static function isStrictlyNotEqualsOperator(string $operator, bool $useStrOperator=true) : bool
    {
        if($useStrOperator){
            return self::OPERATOR_STR_NOT_SEQ === $operator || self::OPERATOR_STR_NOT_SEQ === $operator;
        }

        return self::OPERATOR_STR_NOT_SEQ === $operator;
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