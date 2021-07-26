<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;

class LockExample implements CollectionInterface, AppendableInterface, RemovableInterface, LockableObjectInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemovableInterfaceTrait;
    use LockableObjectInterfaceTrait;
}

echo "Create collection\n";

$collection = new LockExample();

echo "Add 3 different \\stdClass instances:\n\n";

$collection->appendMany([
    new \stdClass,
    new \stdClass,
    new \stdClass,
]);

foreach($collection as $key => $item){
    echo sprintf('%s: %s%s', $key, spl_object_hash($item),"\n");
}

echo "\nModify each collection item with a random number:\n\n";

foreach($collection as $key => $item){
    $item->number = random_int(1, 1000);
    echo "Instance $key: has ->number = {$item->number}\n";
}

echo "Lock the collection ...\n\n";

$collection->lock();

foreach($collection as $key => $item){
    echo sprintf('%s: %s%s', $key, spl_object_hash($item),"\n");
}
