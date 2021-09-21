<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Helper\ComparisonOperatorHelper;

echo "Create array of 5 elements:\n\n";

$array = [
    'a' => 1,
    'b' => 2,
    'c' => 3,
    'd' => 4,
    'e' => 5
];

echo var_export($array, true)."\n\n";

echo "Count:\n\n";

echo IterableHelper::getCount($array)."\n\n";

echo "Filter where value > 2:\n\n";
$result = IterableHelper::filter($array, static function($v){
   return ComparisonOperatorHelper::compare($v, 2,ComparisonOperatorHelper::OPERATOR_GT);
});

echo var_export($result, true)."\n\n";

echo "Map using key (return key => value as string):\n\n";

$result = IterableHelper::map($array, static function($v, $k){
    return 'a' === $k ? $v : "$k => $v";
}, $modified);

echo var_export($result, true)."\n\n";

echo "Amount of items modified:\n";
var_dump($modified);