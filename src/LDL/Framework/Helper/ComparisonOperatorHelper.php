<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Exception\InvalidArgumentException;
final class ComparisonOperatorHelper
{
    /**
     * @param string $operator
     * @throws InvalidArgumentException
     */
    public static function validate(string $operator) : void
    {
        if(self::isValid($operator)){
            return;
        }

        throw new InvalidArgumentException(sprintf(
            '"%s" is not a valid comparison operator. Valid comparison operators are: "%s"',
            $operator,
            implode(', ', Constants::getComparisonOperatorConstants())
        ));
    }

    public static function isValid(string $operator) : bool
    {
        return in_array($operator, Constants::getComparisonOperatorConstants(), true);
    }

    /**
     * @TODO Consider using PHP assert (only when upgrading to 8, suggested by Levy Morrison from PHP Core)
     *
     * @param mixed $left
     * @param mixed $right
     * @param string $operator
     * @param string $order
     * @param mixed $between
     * @throws InvalidArgumentException if given $operator is invalid
     * @return bool
     */
    public static function compare(
        $left,
        $right,
        string $operator,
        string $order=Constants::COMPARE_LTR,
        $between = null
    ) : bool
    {
        self::validate($operator);

        /**
         * Order of operation doesn't matter for equality comparisons
         */
        if(self::isEqualsOperator($operator)) {
            return $left == $right;
        }

        if(self::isStrictlyEqualsOperator($operator)) {
            return $left === $right;
        }

        if(self::isNotEqualsOperator($operator)) {
            return $left != $right;
        }

        if(self::isStrictlyNotEqualsOperator($operator)) {
            return $left !== $right;
        }

        /**
         * Order of comparison DOES matter for arithmetic operations
         */
        if(self::isGreaterOperator($operator)) {
            return $order === Constants::COMPARE_LTR ? $left > $right : $right > $left;
        }

        if(self::isGreaterOrEqualsOperator($operator)) {
            return $order === Constants::COMPARE_LTR ? $left >= $right : $right >= $left;
        }

        if(self::isLowerOperator($operator)) {
            return $order === Constants::COMPARE_LTR ? $left < $right : $right < $left;
        }

        if(self::isLowerOrEqualsOperator($operator)){
            return $order === Constants::COMPARE_LTR ? $left <= $right : $right <= $left;
        }

        if(self::isBetweenOperator($operator)){
            return $order === Constants::COMPARE_LTR ? $between >= $left && $between <= $right : $between >= $right && $between <= $left;
        }

        if(self::isNotBetweenOperator($operator)){
            return $order === Constants::COMPARE_LTR ? $between <= $left && $between >= $right : $between <= $right && $between >= $left;
        }

        throw new InvalidArgumentException("Invalid operator: $operator");
    }

    /**
     * @param $left
     * @param $right
     * @param string $operator
     * @param string $order
     * @param null $between
     * @return bool
     * @throws \Exception
     */
    public static function compareInverse(
        $left,
        $right,
        string $operator,
        string $order=Constants::COMPARE_LTR,
        $between = null
    ) : bool
    {
        self::validate($operator);

        return self::compare($left, $right, self::getOppositeOperator($operator), $order, $between);
    }

    /**
     * @param string $operator
     * @return string
     * @throws \Exception
     */
    public static function getOppositeOperator(string $operator) : string
    {
        self::validate($operator);

        switch($operator){
            case Constants::OPERATOR_EQ:
                return Constants::OPERATOR_NOT_EQ;

            case Constants::OPERATOR_NOT_EQ:
                return Constants::OPERATOR_EQ;

            case Constants::OPERATOR_STR_EQ:
                return Constants::OPERATOR_STR_NOT_EQ;

            case Constants::OPERATOR_STR_NOT_EQ:
                return Constants::OPERATOR_STR_EQ;

            case Constants::OPERATOR_SEQ:
                return Constants::OPERATOR_NOT_SEQ;

            case Constants::OPERATOR_NOT_SEQ:
                return Constants::OPERATOR_SEQ;

            case Constants::OPERATOR_STR_SEQ:
                return Constants::OPERATOR_STR_NOT_SEQ;

            case Constants::OPERATOR_STR_NOT_SEQ:
                return Constants::OPERATOR_STR_SEQ;

            case Constants::OPERATOR_LTE:
                return Constants::OPERATOR_GTE;

            case Constants::OPERATOR_STR_LTE:
                return Constants::OPERATOR_STR_GTE;

            case Constants::OPERATOR_GTE:
                return Constants::OPERATOR_LTE;

            case Constants::OPERATOR_STR_GTE:
                return Constants::OPERATOR_STR_LTE;

            case Constants::OPERATOR_LT:
                return Constants::OPERATOR_GT;

            case Constants::OPERATOR_STR_LT:
                return Constants::OPERATOR_STR_GT;

            case Constants::OPERATOR_GT:
                return Constants::OPERATOR_LT;

            case Constants::OPERATOR_STR_GT:
                return Constants::OPERATOR_STR_LT;

            case Constants::OPERATOR_BETWEEN:
                return Constants::OPERATOR_NOT_BETWEEN;

            case Constants::OPERATOR_STR_BETWEEN:
                return Constants::OPERATOR_STR_NOT_BETWEEN;

            case Constants::OPERATOR_NOT_BETWEEN:
                return Constants::OPERATOR_BETWEEN;

            case Constants::OPERATOR_STR_NOT_BETWEEN:
                return Constants::OPERATOR_STR_BETWEEN;
        }

        return '';
    }

    public static function isEqualsOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_EQ === $operator || Constants::OPERATOR_EQ === $operator;
    }

    public static function isNotEqualsOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_NOT_EQ === $operator || Constants::OPERATOR_NOT_EQ === $operator;
    }

    public static function isStrictlyEqualsOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_SEQ === $operator || Constants::OPERATOR_SEQ === $operator;
    }

    public static function isStrictlyNotEqualsOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_NOT_SEQ === $operator || Constants::OPERATOR_NOT_SEQ === $operator;
    }

    public static function isGreaterOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_GT === $operator || Constants::OPERATOR_GT === $operator;
    }

    public static function isGreaterOrEqualsOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_GTE === $operator || Constants::OPERATOR_GTE === $operator;
    }

    public static function isLowerOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_LT === $operator || Constants::OPERATOR_LT === $operator;
    }

    public static function isLowerOrEqualsOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_LTE === $operator || Constants::OPERATOR_LTE === $operator;
    }

    public static function isBetweenOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_BETWEEN === $operator || Constants::OPERATOR_BETWEEN === $operator;
    }

    public static function isNotBetweenOperator(string $operator) : bool
    {
        return Constants::OPERATOR_STR_NOT_BETWEEN === $operator || Constants::OPERATOR_NOT_BETWEEN === $operator;
    }

    public static function isEqualityOperator(string $operator, bool $includeNegated=true) : bool
    {
        $operators = [
            Constants::OPERATOR_SEQ,
            Constants::OPERATOR_STR_SEQ,
            Constants::OPERATOR_EQ,
            Constants::OPERATOR_STR_EQ
        ];

        if($includeNegated){
            $operators = array_merge($operators, [
                Constants::OPERATOR_NOT_EQ,
                Constants::OPERATOR_STR_NOT_EQ,
                Constants::OPERATOR_NOT_SEQ,
                Constants::OPERATOR_STR_NOT_SEQ
            ]);
        }

        return in_array($operator, $operators, true);
    }

}