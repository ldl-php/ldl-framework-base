<?php declare(strict_types=1);

namespace LDL\Framework\Base;

final class Constants
{
    /**
     * SORT
     */
    public const SORT_ASCENDING  = 'asc';
    public const SORT_DESCENDING = 'desc';

    /**
     * OPERATORS
     */
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

    /**
     * PHP TYPES
     */
    public const PHP_TYPE_STRING = 'string';
    public const PHP_TYPE_BOOL = 'boolean';
    public const PHP_TYPE_ARRAY = 'array';
    public const PHP_TYPE_INTEGER = 'integer';
    public const PHP_TYPE_DOUBLE = 'double';
    public const PHP_TYPE_OBJECT = 'object';
    public const PHP_TYPE_RESOURCE = 'resource';
    public const PHP_TYPE_NULL = 'null';

    /**
     * LDL TYPES
     */
    public const LDL_TYPE_NUMERIC = 'numeric';
    public const LDL_TYPE_UNUMERIC = 'unumeric';
    public const LDL_TYPE_UINT = 'uint';
    public const LDL_TYPE_UDOUBLE = 'udouble';

    /**
     * @var array|null
     */
    private static $typeConstants;

    /**
     * @var array|null
     */
    private static $comparisonOperatorConstants;

    /**
     * @return string[]
     */
    public static function getTypeConstants() : array
    {
        if(null !== self::$typeConstants){
            return self::$typeConstants;
        }

        return self::$typeConstants = [
            sprintf('%s::LDL_TYPE_INT', __CLASS__) => self::PHP_TYPE_INTEGER,
            sprintf('%s::LDL_TYPE_UINT', __CLASS__) => self::LDL_TYPE_UINT,
            sprintf('%s::PHP_TYPE_DOUBLE', __CLASS__) => self::PHP_TYPE_DOUBLE,
            sprintf('%s::PHP_TYPE_STRING', __CLASS__) => self::PHP_TYPE_STRING,
            sprintf('%s::PHP_TYPE_BOOL', __CLASS__) => self::PHP_TYPE_BOOL,
            sprintf('%s::PHP_TYPE_ARRAY', __CLASS__) => self::PHP_TYPE_ARRAY,
            sprintf('%s::PHP_TYPE_NULL', __CLASS__) => self::PHP_TYPE_NULL,
            sprintf('%s::PHP_TYPE_OBJECT', __CLASS__) => self::PHP_TYPE_OBJECT,
            sprintf('%s::PHP_TYPE_RESOURCE', __CLASS__) => self::PHP_TYPE_RESOURCE,
            sprintf('%s::LDL_TYPE_UDOUBLE', __CLASS__) => self::LDL_TYPE_UDOUBLE,
            sprintf('%s::LDL_TYPE_NUMERIC', __CLASS__) => self::LDL_TYPE_NUMERIC,
            sprintf('%s::LDL_TYPE_UNUMERIC', __CLASS__) => self::LDL_TYPE_UNUMERIC
        ];
    }

    /**
     * @return string[]
     */
    public static function getComparisonOperatorConstants() : array
    {
        if(null !== self::$comparisonOperatorConstants){
            return self::$comparisonOperatorConstants;
        }

        return self::$comparisonOperatorConstants = [
            sprintf('%s::OPERATOR_EQ', __CLASS__) => self::OPERATOR_EQ,
            sprintf('%s::OPERATOR_STR_EQ', __CLASS__) => self::OPERATOR_STR_EQ,
            sprintf('%s::OPERATOR_NOT_EQ', __CLASS__) => self::OPERATOR_NOT_EQ,
            sprintf('%s::OPERATOR_STR_NOT_EQ', __CLASS__) => self::OPERATOR_STR_NOT_EQ,
            sprintf('%s::OPERATOR_SEQ', __CLASS__) => self::OPERATOR_SEQ,
            sprintf('%s::OPERATOR_STR_SEQ', __CLASS__) => self::OPERATOR_STR_SEQ,
            sprintf('%s::OPERATOR_NOT_SEQ', __CLASS__) => self::OPERATOR_NOT_SEQ,
            sprintf('%s::OPERATOR_STR_NOT_SEQ', __CLASS__) => self::OPERATOR_STR_NOT_SEQ,
            sprintf('%s::OPERATOR_GT', __CLASS__) => self::OPERATOR_GT,
            sprintf('%s::OPERATOR_STR_GT', __CLASS__) => self::OPERATOR_STR_GT,
            sprintf('%s::OPERATOR_GTE', __CLASS__) => self::OPERATOR_GTE,
            sprintf('%s::OPERATOR_STR_GTE', __CLASS__) => self::OPERATOR_STR_GTE,
            sprintf('%s::OPERATOR_LT', __CLASS__) => self::OPERATOR_LT,
            sprintf('%s::OPERATOR_STR_LT', __CLASS__) => self::OPERATOR_STR_LT,
            sprintf('%s::OPERATOR_LTE', __CLASS__) => self::OPERATOR_LTE,
            sprintf('%s::OPERATOR_STR_LTE', __CLASS__) => self::OPERATOR_STR_LTE,
            sprintf('%s::OPERATOR_BETWEEN', __CLASS__) => self::OPERATOR_BETWEEN,
            sprintf('%s::OPERATOR_STR_BETWEEN', __CLASS__) => self::OPERATOR_STR_BETWEEN,
            sprintf('%s::OPERATOR_NOT_BETWEEN', __CLASS__) => self::OPERATOR_NOT_BETWEEN,
            sprintf('%s::OPERATOR_STR_NOT_BETWEEN', __CLASS__) => self::OPERATOR_STR_NOT_BETWEEN,
        ];
    }

}