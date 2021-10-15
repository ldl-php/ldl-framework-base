<?php declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Base\Collection\Contracts\ComparisonInterface;

class Test1 extends ArrayObject implements ComparisonInterface {
    public function getComparisonValue()
    {
        return 0;
    }
}

class Test2 extends ArrayObject implements ComparisonInterface {
    public function getComparisonValue()
    {
        return [0,1,2,3,4];
    }
}

class Test3 extends ArrayObject implements ComparisonInterface {
    public function getComparisonValue()
    {
        return new Test2();
    }
}

echo "Create array\n";

$arrayObject = new ArrayObject();
$arrayObject->append([
   '1',
    '2',
    'Hello',
    'test'
]);

$items = [
    'Hello',
    'Hello',
    ['example', 'Hello', ['Hello', 'test']],
    'World',
    $arrayObject,
    new Test1(),
    new Test3()
];

echo "Filter unique items:\n\n";
echo var_export(IterableHelper::unique($items),true)."\n\n";