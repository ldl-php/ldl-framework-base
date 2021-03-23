<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Collection\Exception\LockRemoveException;

class MyCollection implements CollectionInterface, AppendableInterface, RemovableInterface, LockRemoveInterface
{
    use CollectionInterfaceTrait;
    use AppendManyTrait;
    use AppendableInterfaceTrait;
    use RemovableInterfaceTrait;
    use LockRemoveInterfaceTrait;
}

echo "Create collection\n";

$collection = new MyCollection();

echo "Append 'Hello World'\n";

$collection->append('Hello world');

echo "Append 'LDL'\n";

$collection->append('LDL');

echo "Append 'example' with key: 'test'\n";

$collection->append('example', 'test');

echo "Append Many: 123, 456\n";

$collection->appendMany([
    123,
    456
]);

echo "Append 789 with key: 111\n";

$collection->append(789, 111);

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

echo "Remove item with key 0 (first)\n";

$collection->remove(0);

echo "Remove item with key 'test'\n";

$collection->remove('test');

echo "Check first key in the collection\n";

echo "key: ".$collection->getFirstKey()."\n";

echo "Check last key in the collection\n";

echo "key: ".$collection->getLastKey()."\n";

echo "Remove last item\n";

$collection->removeLast();

echo "Remove item with key 3\n";

$collection->remove(3);

echo "Remove item with key 4\n";

$collection->remove(4);

echo "First and Last must be the same\n";

echo "First key: ".$collection->getFirstKey()."\n";
echo "Last key: ".$collection->getLastKey()."\n";

echo "Lock remove\n";

$collection->lockRemove();

try{
    echo "Try to remove an item, exception must be thrown\n";
    $collection->removeLast();
}catch(LockRemoveException $e){
    echo "EXCEPTION: {$e->getMessage()}\n";
}

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}
