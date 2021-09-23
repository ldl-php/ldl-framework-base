<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\RemoveByValueInterface;
use LDL\Framework\Base\Collection\Traits\RemoveByValueInterfaceTrait;
use LDL\Framework\Helper\IterableHelper;

class RemoveLastExample implements CollectionInterface, AppendableInterface, RemoveByKeyInterface, RemoveByValueInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemoveByKeyInterfaceTrait;
    use RemoveByValueInterfaceTrait;
}

echo "Create collection\n";

$collection = new RemoveLastExample();

$items = [
    'a',
    'test' => 'b',
    'c',
    'd'
];

echo "Append items:\n";
echo var_export($items,true)."\n\n";
$collection->appendMany($items, true);

echo "Remove last (2 => 'd' must be removed):\n";
$collection->removeLast();
echo "Items in collection: {$collection->count()}\n";

echo var_export(IterableHelper::toArray($collection), true)."\n";

echo "Check first and last key\n";
echo "First key: ".$collection->getFirstKey()."\n";
echo "Last key: ".$collection->getLastKey()."\n\n";

echo "Remove last (1 => 'c' must be removed):\n";
$collection->removeLast();
echo "Items in collection: {$collection->count()}\n";

echo var_export(IterableHelper::toArray($collection), true)."\n";

echo "Check first and last key\n";
echo "First key: ".$collection->getFirstKey()."\n";
echo "Last key: ".$collection->getLastKey()."\n\n";

echo "Remove last ('test' => 'b' must be removed):\n";
$collection->removeLast();
echo "Items in collection: {$collection->count()}\n";

echo var_export(IterableHelper::toArray($collection), true)."\n";

echo "Check first and last key\n";
echo "First key: ".$collection->getFirstKey()."\n";
echo "Last key: ".$collection->getLastKey()."\n\n";

echo "Remove last (0 => 'a' must be removed):\n";
$collection->removeLast();
echo "Items in collection: {$collection->count()}\n";

echo var_export(IterableHelper::toArray($collection), true)."\n";

echo "Check first and last key\n";
echo "First key: ".$collection->getFirstKey()."\n";
echo "Last key: ".$collection->getLastKey()."\n\n";

