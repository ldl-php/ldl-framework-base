<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Exception\LockRemoveException;

class MyLDLCollection implements CollectionInterface, AppendableInterface, RemoveByKeyInterface, LockRemoveInterface
{
    use CollectionInterfaceTrait;
    use AppendManyTrait;
    use AppendableInterfaceTrait;
    use RemoveByKeyInterfaceTrait;
    use LockRemoveInterfaceTrait;
}

echo "Create collection\n";

$collection = new MyLDLCollection();

echo "Append 'Hello World'\n";

$collection->append('Hello world');

echo "Append 'LDL'\n";

$collection->append('LDL');

echo "Append 'example' with key: 'test'\n";

$collection->append('example', 'test');

echo "Append Many: 123, 456\n";

$collection->appendMany([
    0 => 123,
    1 => 456
]);

echo "Append 789 with key: 111\n";

$collection->append(789, 111);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

echo "Remove item with key 0 (first)\n";
$collection->removeByKey(0);

echo "Remove item with key 'test'\n";
$collection->removeByKey('test');

echo "Check first key in the collection\n";

echo "key: ".$collection->getFirstKey()."\n";

echo "Check last key in the collection\n";

echo "key: ".$collection->getLastKey()."\n";

echo "Remove last item\n";

$collection->removeLast();

echo "Try to remove item with key 4 (which does not exists)\n";
$removed = $collection->removeByKey(4);

if($removed === 0){
    echo "OK: Key 4 does not exist in the collection\n";
}

echo "Remove item with key 1\n";

$collection->removeByKey(1);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

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

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";
