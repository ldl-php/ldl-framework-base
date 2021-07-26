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

echo "\nModify each collection item with a random number:\n\n";

$nums = [];
foreach($collection as $key => $item){
    $item->number = random_int(1, 1000);
    $nums[] = $item->number;
    echo sprintf('%s: %s%s',  spl_object_hash($item),$item->number, "\n");
}

echo "\nLock the collection ...\n\n";

$collection->lock();

/**
 * Trigger hash persistence internally so objects don't get destroyed by the PHP engine
 * In this way we achieve different hashes, showing that the internal cloning works
 * when the object is locked
 */

echo "Attempt to change numbers through iteration:\n\n";

$items = [];

foreach($collection as $key => $item){
    $item->number = random_int(1001, 9999);
    echo sprintf('%s: %s%s',  spl_object_hash($item),$item->number, "\n");
    $items[] = $item;
}

echo sprintf(
    '%sCollection is locked, numbers must be the same: %s%s',
    "\n",
    implode(',', $nums),
    "\n\n"
);

foreach($collection as $key => $item){
    echo sprintf('%s: %s%s',  spl_object_hash($item),$item->number, "\n");
}

