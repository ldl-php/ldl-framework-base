<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\ComparisonOperatorHelper;

echo "Create array of 7 elements:\n\n";

$dp = opendir(sys_get_temp_dir());

$items = [
    0x25,
    0b01001,
    '5 dogs',
    '10',
    9e99,
    0,
    -1,
    $dp,
    null,
    []
];

foreach(Constants::getTypeConstants() as $name=>$filter){
    echo sprintf("Filter items by %s: %s\n" , $name, $filter);
    echo str_repeat('#', 80)."\n\n";
    echo var_dump(IterableHelper::filterByValueType($items, $filter))."\n";
}

closedir($dp);
