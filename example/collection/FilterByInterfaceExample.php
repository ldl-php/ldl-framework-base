<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\KeyFilterInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceableInterface;
use LDL\Framework\Base\Collection\Contracts\UnshiftInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\KeyFilterInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\ReplaceableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\UnshiftInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\FilterByInterface;
use LDL\Framework\Base\Collection\Traits\FilterByInterfaceTrait;

interface FilterByInterfaceExample extends CollectionInterface, AppendableInterface, KeyFilterInterface, RemovableInterface, ReplaceableInterface, UnshiftInterface, FilterByInterface
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

class FilterByInterfaceCollection implements FilterByInterfaceExample
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use KeyFilterInterfaceTrait;
    use RemovableInterfaceTrait;
    use ReplaceableInterfaceTrait;
    use UnshiftInterfaceTrait;
    use FilterByInterfaceTrait;
}

echo "Create collection\n";

$collection = new FilterByInterfaceCollection();
$collection->append(new FooLDL())
    ->append(new BarLDL())
    ->append(new FooBarLDL());

echo "Filter by Interface A: (Foo must be shown)\n";
var_dump(get_class($collection->filterByInterface(A::class)[0]));

echo "Filter by interfaces, A and B with strict mode set to false (Foo, Bar and FooBar must be shown)\n";

foreach($collection->filterByInterfaces([A::class, B::class], false) as $item){
    var_dump(get_class($item));
}

echo "Filter by interface A and B (FooBar must be shown)\n";
foreach($collection->filterByInterfaces([A::class, B::class], true) as $item){
    var_dump(get_class($item));
}

