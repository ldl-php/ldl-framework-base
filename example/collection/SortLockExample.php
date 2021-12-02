<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Exception\LDLException;
use LDL\Framework\Base\Contracts\LockSortInterface;
use LDL\Framework\Base\Traits\LockSortInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Collection\Contracts\SortInterface;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\SortInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\HasSortValueInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;

class SortLockExample implements CollectionInterface, AppendableInterface, LockSortInterface, SortInterface, LockableObjectInterface
{
    use AppendManyTrait;
    use SortInterfaceTrait;
    use LockSortInterfaceTrait;
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use LockableObjectInterfaceTrait;
}
class ObjectWithSortValue implements HasSortValueInterface
{
    private $property = 1;

    public function getSortValue()
    {
        return $this->property;
    }
}

$items = [
    55,
    "a",
    10,
    new ObjectWithSortValue()
];

echo "Create collection\n";

$collection = new SortLockExample();

echo "\nAppend items to be sorted in collection:\n";

$collection->appendMany($items);

echo var_export(iterator_to_array($collection), true) . "\n";

echo "\nLock the collection with sort lock to prevent sorting\n";

$collection->lockSort();

try {
    echo "\nSorting a collection with sort lock (EXCEPTION must be thrown)\n";
    $collection->sort();
} catch (LDLException $e) {
    echo "OK Exception {$e->getMessage()}\n";
}

echo "\nCreate collection\n";

$collection = new SortLockExample();

echo "\nAppend items to be sorted in collection:\n";

$collection->appendMany($items);

echo var_export(iterator_to_array($collection), true) . "\n";

echo "\nLock the collection with object lock to prevent sorting\n";

$collection->lock();

try {
    echo "\nSorting a collection with object lock (EXCEPTION must be thrown)\n";
    $collection->sort();
} catch (LDLException $e) {
    echo "OK Exception {$e->getMessage()}\n";
}
