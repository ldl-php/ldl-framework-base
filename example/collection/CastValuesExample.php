<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\IterableHelper;

class CastValuesExample implements CollectionInterface, AppendableInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
}

class Test1 {
    public function __toString(): string
    {
        return '-1';
    }
}

class Test2 {
    public function __toString(): string
    {
        return '-2';
    }
}

class Test3 {
    public function __toString(): string
    {
        return '-3';
    }
}

echo "Create collection\n";

$collection = new CastValuesExample();

$items = [
    1,
    2,
    -3,
    true,
    false,
    null,
    1.1,
    -1.2,
    'hello'
];

echo "Append items:\n\n";
echo var_export($items,true)."\n\n";
$collection->appendMany($items, true);

echo "Append class Test1 with __toString = '-1'\n";
echo "Append class Test2 with __toString = '-2'\n";
echo "Append class Test3 with __toString = '-3'\n\n";
$collection->appendMany([
    new Test1(),
    new Test2(),
    new Test3()
]);

echo "Check items in collection\n\n";
echo var_export($collection->toArray(),true)."\n\n";

echo "Cast collection to string\n\n";
foreach(IterableHelper::cast($collection, Constants::PHP_TYPE_STRING) as $k => $item){
    $type = gettype($item);
    echo "Item key: '$k' | value: '$item' | type: '$type'\n";
}

echo "\n";
echo "Cast collection to integer\n\n";
foreach(IterableHelper::cast($collection, Constants::PHP_TYPE_INTEGER) as $k => $item){
    $type = gettype($item);
    echo "Item key: '$k' | value: '$item' | type: '$type'\n";
}

echo "\n";
echo "Cast collection to boolean\n\n";
foreach(IterableHelper::cast($collection, Constants::PHP_TYPE_BOOL) as $k => $item){
    $type = gettype($item);
    echo "Item key: '$k' | value: '$item' | type: '$type'\n";
}

echo "\n";
echo "Cast collection to uint\n\n";
foreach(IterableHelper::cast($collection, Constants::LDL_TYPE_UINT) as $k => $item){
    $type = gettype($item);
    echo "Item key: '$k' | value: '$item' | type: '$type'\n";
}