<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\PrioritySortingInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\PrioritySortingInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Contracts\PriorityInterface;

class PriorityClass1 implements PriorityInterface
{
    public function getPriority(): int
    {
        return 1;
    }
}

class PriorityClass2 implements PriorityInterface
{
    public function getPriority(): int
    {
        return 2;
    }
}

class PriorityClass3
{
    public function getPriority(): int
    {
        return 3;
    }
}

class PriorityCollection implements CollectionInterface, AppendableInterface, PrioritySortingInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use PrioritySortingInterfaceTrait;
}

echo "Create new PriorityCollection class instance\n";
$collection = new PriorityCollection();

echo "Append PriorityClass2\n";
$collection->append(new PriorityClass2());

echo "Append PriorityClass1\n";
$collection->append(new PriorityClass1());

echo "Append PriorityClass3 (does not implement PriorityInterface)\n";
$collection->append(new PriorityClass3());

echo "Sort by priority ascending:\n";

/**
 * @var PriorityInterface $item
 */
foreach($collection->sortByPriority(Constants::SORT_ASCENDING) as $item){
    echo $item->getPriority()."\n";
}

echo "\nSort by priority descending:\n";

/**
 * @var PriorityInterface $item
 */
foreach($collection->sortByPriority(Constants::SORT_DESCENDING) as $item){
    echo $item->getPriority()."\n";
}