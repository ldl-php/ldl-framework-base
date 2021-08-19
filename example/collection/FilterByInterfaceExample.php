<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\KeyFilterInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Contracts\UnshiftInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\KeyFilterInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\UnshiftInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\FilterByInterface;
use LDL\Framework\Base\Collection\Traits\FilterByInterfaceTrait;

interface FilterByInterfaceExample extends CollectionInterface, AppendableInterface, KeyFilterInterface, RemovableInterface, UnshiftInterface, FilterByInterface
{

}

interface A{

}

interface B{

}

class FooLDL implements A{

}

class BarLDL implements B{

}

class FooBarLDL implements A, B
{

}

class FooBarExtended extends FooLDL{

}

class FilterByInterfaceCollection implements FilterByInterfaceExample
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use KeyFilterInterfaceTrait;
    use RemovableInterfaceTrait;
    use UnshiftInterfaceTrait;
    use FilterByInterfaceTrait;
}

echo "Create collection\n";

$collection = new FilterByInterfaceCollection();
$collection->append(new FooLDL())
    ->append(new BarLDL())
    ->append(new FooBarLDL())
    ->append(new FooBarExtended());

echo "Filter by Interface A: (FooLDL, FooBarLDL and FooBarExtended must be shown)\n";
foreach($collection->filterByInterface(A::class) as $item){
    var_dump(get_class($item));
}

echo "Filter by interfaces, A and B with strict mode set to false (FooLDL, BarLDL, FooBarLDL and FooBarExtended must be shown)\n";

foreach($collection->filterByInterfaces([A::class, B::class], false) as $item){
    var_dump(get_class($item));
}

echo "Filter by interface A and B (FooBarLDL must be shown)\n";
foreach($collection->filterByInterfaces([A::class, B::class], true) as $item){
    var_dump(get_class($item));
}

echo "Filter by Interface A recursive: (FooLDL, FooBarLDL and FooBarExtended must be shown)\n";
foreach($collection->filterByInterfaceRecursive(A::class) as $item){
    var_dump(get_class($item));
}