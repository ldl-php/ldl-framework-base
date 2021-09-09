<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\KeyFilterInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\KeyFilterInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Traits\BeforeReplaceInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\ReplaceEqualValueInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Collection\Traits\ReplaceByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\ReplaceEqualValueInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\ReplaceMissingKeyInterface;
use LDL\Framework\Base\Collection\Traits\ReplaceMissingKeyInterfaceTrait;

interface MyCollectionInterface extends CollectionInterface, KeyFilterInterface, RemoveByKeyInterface, ReplaceByKeyInterface, ReplaceEqualValueInterface, BeforeReplaceInterface, ReplaceMissingKeyInterface
{

}

abstract class MyCollection implements MyCollectionInterface
{
    use CollectionInterfaceTrait;
    use KeyFilterInterfaceTrait;
    use RemoveByKeyInterfaceTrait;
    use ReplaceByKeyInterfaceTrait;
    use ReplaceEqualValueInterfaceTrait;
    use BeforeReplaceInterfaceTrait;
    use ReplaceMissingKeyInterfaceTrait;
}

abstract class MyChildCollection extends MyCollection implements AppendableInterface
{
    use AppendableInterfaceTrait;
    use AppendManyTrait;
}

class MyAppendableCollection extends MyChildCollection
{
    public function __construct()
    {
        $this->onReplaceMissingKey()->append(static function($obj, $value, $replaceable){
            $obj->append($replaceable);
        });
    }
}

echo "Create collection\n";

$collection = new MyAppendableCollection();

echo "Append single item: 'hello'\n";

$collection->append('hello');

echo "Get value at offset 0\n";

var_dump($collection->get(0));

echo "Append many items: 'LDL', 'LDL', 'World'\n";

$collection->appendMany(['LDL', 'LDL', 'World']);

echo "Check items in the collection\n";

foreach($collection as $value){
    echo "Item: $value\n";
}

echo "Replace item by key 'World' with 'World!!'\n";

$collection->replaceByKey('World!!', 3);

echo "Replace items by value 'LDL' with 'crazy'\n";

$collection->replaceByEqualValue('LDL', 'crazy');

echo "Check items in the collection\n";

foreach($collection as $value){
    echo "Item: $value\n";
}

echo "Replace item with key: 'lol' (which does not exist) and value: 'something', it must be append to the collection\n";
$collection->replaceByKey('something', 'lol');

echo "Check items in the collection\n";

foreach($collection as $value){
    echo "Item: $value\n";
}