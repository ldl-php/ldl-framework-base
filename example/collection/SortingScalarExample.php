<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\SortableScalarInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\SortableScalarTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;

class ScalarCollection implements CollectionInterface, AppendableInterface, SortableScalarInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use SortableScalarTrait;
}

echo "Create new PriorityCollection class instance\n";
$collection = new ScalarCollection();

echo "Append [1,2,3,4,5,'a','b','c','d','e']\n";
$collection->appendMany([1,2,3,4,5,'a','b','c','d','e']);

echo "Sort ascending:\n";

foreach($collection->sortScalar(SortableScalarInterface::SORT_ASCENDING) as $item){
    echo $item."\n";
}

echo "\nSort descending:\n";

foreach($collection->sortScalar(SortableScalarInterface::SORT_DESCENDING) as $item){
    echo $item."\n";
}