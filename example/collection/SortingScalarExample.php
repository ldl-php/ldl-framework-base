<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\SortableScalarInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\SortableScalarInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Constants;

class ScalarCollection implements CollectionInterface, AppendableInterface, SortableScalarInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use SortableScalarInterfaceTrait;
}

echo "Create new PriorityCollection class instance\n";
$collection = new ScalarCollection();

echo "Append [2,'a','e',1,5,'b','d',3,'c',4]\n";
$collection->appendMany([2,'a','e',1,5,'b','d',3,'c',4]);

echo "Sort ascending:\n";

foreach($collection->sortScalar(Constants::SORT_ASCENDING) as $item){
    echo $item."\n";
}

echo "\nSort descending:\n";

foreach($collection->sortScalar(Constants::SORT_DESCENDING) as $item){
    echo $item."\n";
}