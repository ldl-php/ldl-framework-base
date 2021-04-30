<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByActiveStateInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\FilterByActiveStateInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Contracts\IsActiveInterface;

class ActiveStateFilterExampleTest1 implements IsActiveInterface
{
    public function isActive(): bool
    {
        return true;
    }
}

class ActiveStateFilterExampleTest2 implements IsActiveInterface
{
    public function isActive(): bool
    {
        return false;
    }
}

class FilterByActiveStateCollection implements CollectionInterface, AppendableInterface, FilterByActiveStateInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use FilterByActiveStateInterfaceTrait;
}

echo "Create Active State Collection instance\n";

$collection = new FilterByActiveStateCollection();

echo "Append class ActiveStateFilterExampleTest1 with active: true\n";

$collection->append(new ActiveStateFilterExampleTest1());

echo "Append class ActiveStateFilterExampleTest2 with active: false\n";

$collection->append(new ActiveStateFilterExampleTest2());

echo "Filter class by active state\n";

foreach($collection->filterByActiveState() as $item){
    echo get_class($item)."\n";
}