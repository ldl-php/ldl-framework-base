<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\ComparisonOperatorHelper;

function pr(string $operator)
{
    echo "Get opposite operator of: $operator\n";
    var_dump(ComparisonOperatorHelper::getOppositeOperator($operator));
}

pr(Constants::OPERATOR_NOT_EQ);
pr(Constants::OPERATOR_EQ);
pr(Constants::OPERATOR_SEQ);
pr(Constants::OPERATOR_NOT_SEQ);
pr(Constants::OPERATOR_GT);
pr(Constants::OPERATOR_LT);
pr(Constants::OPERATOR_GTE);
pr(Constants::OPERATOR_LTE);

pr(Constants::OPERATOR_STR_NOT_EQ);
pr(Constants::OPERATOR_STR_EQ);
pr(Constants::OPERATOR_STR_SEQ);
pr(Constants::OPERATOR_STR_NOT_SEQ);
pr(Constants::OPERATOR_STR_GT);
pr(Constants::OPERATOR_STR_LT);
pr(Constants::OPERATOR_STR_GTE);
pr(Constants::OPERATOR_STR_LTE);
pr(Constants::OPERATOR_STR_BETWEEN);
pr(Constants::OPERATOR_BETWEEN);
pr(Constants::OPERATOR_NOT_BETWEEN);
pr(Constants::OPERATOR_STR_NOT_BETWEEN);