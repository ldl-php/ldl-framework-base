<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Base\Collection\Contracts\ComparisonInterface;

class UniqueExample implements CollectionInterface, AppendableInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
}

class Test1 implements ComparisonInterface {
    public function getComparisonValue()
    {
        return 0;
    }
}

class Test2 implements ComparisonInterface {
    public function getComparisonValue()
    {
        return 0;
    }
}

class Test3 implements ComparisonInterface {
    public function getComparisonValue()
    {
        return 'a';
    }
}

echo "Create collection\n";

$collection = new UniqueExample();

$items = [
    'Hello',
    'Hello',
    'Hello',
    'World'
];

echo "Append items:\n\n";
echo var_export($items,true)."\n\n";
$collection->appendMany($items, true);

echo "Append class Test1 with comparison value = 0\n";
echo "Append class Test2 with comparison value = 0\n";
echo "Append class Test3 with comparison value = 'a'\n\n";
$collection->appendMany([
    new Test1(),
    new Test2(),
    new Test3()
]);

echo "Check items in collection\n\n";
echo var_export($collection->toArray(),true)."\n\n";

echo "Get unique collection\n\n";
foreach(IterableHelper::unique($collection) as $k => $item){
    $print = is_object($item) ? get_class($item) : $item;
    echo "Item key: '$k' | value: '$print'\n";
}