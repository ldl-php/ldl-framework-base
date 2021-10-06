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
    public const LDL_TYPE_STRNUM = 'strnum';
    public const LDL_TYPE_UINT = 'uint';
    public const LDL_TYPE_UDOUBLE = 'udouble';
}