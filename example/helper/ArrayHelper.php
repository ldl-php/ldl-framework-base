<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Helper\ArrayHelper\ArrayHelper;

echo "Create array of 5 elements:\n\n";

$array = [
    'a' => 1,
    'b' => 2,
    'c' => 3,
    'd' => 4,
    'e' => 5
];

echo var_export($array, true)."\n\n";

$replaced = ArrayHelper::replaceByCallback($array, '20', static function($v, $k){
    return $v > 2;
});

echo var_export($array, true)."\n\n";

if(3 !== $replaced){
    throw new \Exception('Replaced item count is not 3!');
}
echo "Amount of replaced items:\n\n";
var_dump($replaced);