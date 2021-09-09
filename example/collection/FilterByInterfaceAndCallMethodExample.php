<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\KeyFilterInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Contracts\AppendInPositionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\KeyFilterInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendInPositionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\FilterByInterface;
use LDL\Framework\Base\Collection\Traits\FilterByInterfaceTrait;

interface FilterByInterfaceAndCallMethodExample extends CollectionInterface, AppendableInterface, KeyFilterInterface, RemoveByKeyInterface, AppendInPositionInterface, FilterByInterface
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
    use RemoveByKeyInterfaceTrait;
    use AppendInPositionInterfaceTrait;
    use FilterByInterfaceTrait;
}

echo "Create collection\n";

$collection = new FilterByInterfaceCollection();
$collection->append(new FooLDL())
    ->append(new BarLDL())
    ->append(new FooBarLDL())
    ->append(new FooBarExtended());

echo "Filter by Interface A: (FooLDL and his callback 'Howdy!' must be shown)\n";

foreach($collection->filterByInterfaceAndCallMethod(A::class,'test','Howdy!') as $item){
    var_dump(get_class($item));
}
