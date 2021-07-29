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

interface FilterByInterfaceAndCallMethodExample extends CollectionInterface, AppendableInterface, KeyFilterInterface, RemovableInterface, ReplaceableInterface, UnshiftInterface, FilterByInterface
{

}

interface A{
    public function test(string $value) : void;
}

trait ATrait{
    public function test(string $value) : void
    {
        echo $value."\n";
    }
}

interface B{

}

class FooLDL implements A{
    use ATrait;
}

class BarLDL implements B{
    use ATrait;
}

class FooBarLDL implements A, B
{
    use ATrait;
}

class FooBarExtended extends FooLDL{

}

class FilterByInterfaceCollection implements FilterByInterfaceAndCallMethodExample
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
    ->append(new FooBarLDL())
    ->append(new FooBarExtended());

echo "Filter by Interface A: (FooLDL must be shown)\n";

foreach($collection->filterByInterfaceAndCallMethod(A::class,'test','Howdy!') as $item){
    var_dump(get_class($item));
}
