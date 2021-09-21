<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Helper\ComparisonOperatorHelper;

function pr(string $operator)
{
    echo "Get opposite operator of: $operator\n";
    var_dump(ComparisonOperatorHelper::getOppositeOperator($operator));
}

pr(ComparisonOperatorHelper::OPERATOR_NOT_EQ);
pr(ComparisonOperatorHelper::OPERATOR_EQ);
pr(ComparisonOperatorHelper::OPERATOR_SEQ);
pr(ComparisonOperatorHelper::OPERATOR_NOT_SEQ);
pr(ComparisonOperatorHelper::OPERATOR_GT);
pr(ComparisonOperatorHelper::OPERATOR_LT);
pr(ComparisonOperatorHelper::OPERATOR_GTE);
pr(ComparisonOperatorHelper::OPERATOR_LTE);

pr(ComparisonOperatorHelper::OPERATOR_STR_NOT_EQ);
pr(ComparisonOperatorHelper::OPERATOR_STR_EQ);
pr(ComparisonOperatorHelper::OPERATOR_STR_SEQ);
pr(ComparisonOperatorHelper::OPERATOR_STR_NOT_SEQ);
pr(ComparisonOperatorHelper::OPERATOR_STR_GT);
pr(ComparisonOperatorHelper::OPERATOR_STR_LT);
pr(ComparisonOperatorHelper::OPERATOR_STR_GTE);
pr(ComparisonOperatorHelper::OPERATOR_STR_LTE);
pr(ComparisonOperatorHelper::OPERATOR_STR_BETWEEN);
pr(ComparisonOperatorHelper::OPERATOR_BETWEEN);
pr(ComparisonOperatorHelper::OPERATOR_NOT_BETWEEN);
pr(ComparisonOperatorHelper::OPERATOR_STR_NOT_BETWEEN);