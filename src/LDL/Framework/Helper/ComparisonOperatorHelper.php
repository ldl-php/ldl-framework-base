<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

final class ComparisonOperatorHelper
{
    public const COMPARE_LTR = 'ltr';
    public const COMPARE_RTL = 'rtl';

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
    public const OPERATOR_STR_LTE='lte';

    public const OPERATOR_BETWEEN = '<>';
    public const OPERATOR_STR_BETWEEN = 'btw';

    public const OPERATOR_NOT_BETWEEN = '!<>';
    public const OPERATOR_STR_NOT_BETWEEN = 'nbtw';

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
            self::OPERATOR_STR_LTE,
            self::OPERATOR_BETWEEN,
            self::OPERATOR_STR_BETWEEN,
            self::OPERATOR_NOT_BETWEEN,
            self::OPERATOR_STR_NOT_BETWEEN
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
     * @param mixed $left
     * @param mixed $right
     * @param string $operator
     * @param string $order
     * @param mixed $between
     * @throws \InvalidArgumentException if given $operator is invalid
     * @return bool
     */
    public static function compare(
        $left,
        $right,
        string $operator,
        string $order=self::COMPARE_LTR,
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
            return $order === self::COMPARE_LTR ? $left > $right : $right > $left;
        }

        if(self::isGreaterOrEqualsOperator($operator)) {
            return $order === self::COMPARE_LTR ? $left >= $right : $right >= $left;
        }

        if(self::isLowerOperator($operator)) {
            return $order === self::COMPARE_LTR ? $left < $right : $right < $left;
        }

        if(self::isLowerOrEqualsOperator($operator)){
            return $order === self::COMPARE_LTR ? $left <= $right : $right <= $left;
        }

        if(self::isBetweenOperator($operator)){
            return $order === self::COMPARE_LTR ? $between >= $left && $between <= $right : $between >= $right && $between <= $left;
        }

        if(self::isNotBetweenOperator($operator)){
            return $order === self::COMPARE_LTR ? $between <= $left && $between >= $right : $between <= $right && $between >= $left;
        }

        throw new \InvalidArgumentException("Invalid operator: $operator");
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
        string $order=self::COMPARE_LTR,
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
            case self::OPERATOR_EQ:
                return self::OPERATOR_NOT_EQ;

            case self::OPERATOR_NOT_EQ:
                return self::OPERATOR_EQ;

            case self::OPERATOR_STR_EQ:
                return self::OPERATOR_STR_NOT_EQ;

            case self::OPERATOR_STR_NOT_EQ:
                return self::OPERATOR_STR_EQ;

            case self::OPERATOR_SEQ:
                return self::OPERATOR_NOT_SEQ;

            case self::OPERATOR_NOT_SEQ:
                return self::OPERATOR_SEQ;

            case self::OPERATOR_STR_SEQ:
                return self::OPERATOR_STR_NOT_SEQ;

            case self::OPERATOR_STR_NOT_SEQ:
                return self::OPERATOR_STR_SEQ;

            case self::OPERATOR_LTE:
                return self::OPERATOR_GTE;

            case self::OPERATOR_STR_LTE:
                return self::OPERATOR_STR_GTE;

            case self::OPERATOR_GTE:
                return self::OPERATOR_LTE;

            case self::OPERATOR_STR_GTE:
                return self::OPERATOR_STR_LTE;

            case self::OPERATOR_LT:
                return self::OPERATOR_GT;

            case self::OPERATOR_STR_LT:
                return self::OPERATOR_STR_GT;

            case self::OPERATOR_GT:
                return self::OPERATOR_LT;

            case self::OPERATOR_STR_GT:
                return self::OPERATOR_STR_LT;

            case self::OPERATOR_BETWEEN:
                return self::OPERATOR_NOT_BETWEEN;

            case self::OPERATOR_STR_BETWEEN:
                return self::OPERATOR_STR_NOT_BETWEEN;

            case self::OPERATOR_NOT_BETWEEN:
                return self::OPERATOR_BETWEEN;

            case self::OPERATOR_STR_NOT_BETWEEN:
                return self::OPERATOR_STR_BETWEEN;
        }

        return '';
    }

    public static function isEqualsOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_EQ === $operator || self::OPERATOR_EQ === $operator;
    }

    public static function isNotEqualsOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_NOT_EQ === $operator || self::OPERATOR_NOT_EQ === $operator;
    }

    public static function isStrictlyEqualsOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_SEQ === $operator || self::OPERATOR_SEQ === $operator;
    }

    public static function isStrictlyNotEqualsOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_NOT_SEQ === $operator || self::OPERATOR_NOT_SEQ === $operator;
    }

    public static function isGreaterOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_GT === $operator || self::OPERATOR_GT === $operator;
    }

    public static function isGreaterOrEqualsOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_GTE === $operator || self::OPERATOR_GTE === $operator;
    }

    public static function isLowerOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_LT === $operator || self::OPERATOR_LT === $operator;
    }

    public static function isLowerOrEqualsOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_LTE === $operator || self::OPERATOR_LTE === $operator;
    }

    public static function isBetweenOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_BETWEEN === $operator || self::OPERATOR_BETWEEN === $operator;
    }

    public static function isNotBetweenOperator(string $operator) : bool
    {
        return self::OPERATOR_STR_NOT_BETWEEN === $operator || self::OPERATOR_NOT_BETWEEN === $operator;
    }

    public static function isEqualityOperator(string $operator, bool $includeNegated=true) : bool
    {
        $operators = [
            self::OPERATOR_SEQ,
            self::OPERATOR_STR_SEQ,
            self::OPERATOR_EQ,
            self::OPERATOR_STR_EQ
        ];

        if($includeNegated){
            $operators = array_merge($operators, [
                self::OPERATOR_NOT_EQ,
                self::OPERATOR_STR_NOT_EQ,
                self::OPERATOR_NOT_SEQ,
                self::OPERATOR_STR_NOT_SEQ
            ]);
        }

        return in_array($operator, $operators, true);
    }

}