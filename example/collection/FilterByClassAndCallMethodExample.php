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
use LDL\Framework\Base\Collection\Contracts\FilterByClassInterface;
use LDL\Framework\Base\Collection\Traits\FilterByClassInterfaceTrait;

interface FilterByClassAndCallExample extends CollectionInterface, AppendableInterface, KeyFilterInterface, RemovableInterface, ReplaceableInterface, UnshiftInterface, FilterByClassInterface
{

}

class Foo{
    public function test(string $string){
        echo $string."\n";
    }
}

class Bar{

}

class FooBar{

}

class ExtendsFoo extends Foo
{

}

class ExtendsBar extends Bar
{

}

class FilterByClassCollection implements FilterByClassAndCallExample
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use KeyFilterInterfaceTrait;
    use RemovableInterfaceTrait;
    use ReplaceableInterfaceTrait;
    use UnshiftInterfaceTrait;
    use FilterByClassInterfaceTrait;
}

echo "Create collection\n";

$collection = new FilterByClassCollection();

echo "Append Foo, Bar, Bar, FooBar, ExtendsFoo and ExtendsBar classes\n";

$collection->append(new Foo)
    ->append(new Bar)
    ->append(new Bar)
    ->append(new FooBar)
    ->append(new ExtendsFoo)
    ->append(new ExtendsBar);

echo "Filter by class Foo: (Foo must be shown)\n";

foreach($collection->filterByClassAndCallMethod(Foo::class,'test', 'hello foo!') as $item){
    var_dump(get_class($item));
}
