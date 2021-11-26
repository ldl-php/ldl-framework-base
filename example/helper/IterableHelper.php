<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Base\Exception\LogicException;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Base\Contracts\Type\ToArrayInterface;

class MyArrayClass implements ToArrayInterface{

    public function toArray(bool $useKeys = null): array
    {
        return [40,50,60,60,60,'a','b','c',-20];
    }

}

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
   return ComparisonOperatorHelper::compare($v, 2,Constants::OPERATOR_GT);
});

echo var_export($result, true)."\n\n";

echo "Map using key (return key => value as string) preserve keys is enabled:\n";
echo "Only 4 items must be modified\n\n";

$result = IterableHelper::map($array, static function($v, $k){
    return 'a'=== $k ? $v : "$k => $v";
}, true, $modified);

if(4 !== $modified){
    throw new LogicException('Amount of modified items must be 4!');
}

echo "Amount of items modified: $modified\n\n";

unset($modified);

echo var_export($result, true)."\n\n";

echo "Map using key (return key => value as string) preserve keys is disabled:\n\n";

$result = IterableHelper::map($array, static function($v, $k){
    return "$k => $v";
}, true, $modified);

echo var_export($result, true)."\n\n";

echo "Amount of items modified:\n";
var_dump($modified);

echo "Create an instance of MyArrayClass (implements ToArrayInterface)\n\n";

$obj = new MyArrayClass();

echo "Map each value from MyArrayClass\n";

IterableHelper::map($obj, function($i){
    echo $i."\n";
});

echo "Get unique values from MyArrayClass\n\n";

echo var_export(IterableHelper::unique($obj), true);

echo "\nFilter value types in MyArrayClass, Integers only:\n\n";

echo var_export(IterableHelper::filterByValueType($obj, Constants::PHP_TYPE_INTEGER), true);

echo "\n\nFilter value types in MyArrayClass, Strings only:\n\n";

echo var_export(IterableHelper::filterByValueType($obj, Constants::PHP_TYPE_STRING), true);
