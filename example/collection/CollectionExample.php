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
use LDL\Framework\Base\Collection\Traits\HasDuplicateKeyVerificationInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Traits\BeforeReplaceInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\ReplaceEqualValueInterface;
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Collection\Traits\ReplaceByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\ReplaceEqualValueInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\ReplaceMissingKeyInterface;
use LDL\Framework\Base\Collection\Traits\ReplaceMissingKeyInterfaceTrait;

interface MyCollectionInterface extends CollectionInterface, KeyFilterInterface, RemovableInterface, ReplaceByKeyInterface, ReplaceEqualValueInterface, UnshiftInterface, BeforeReplaceInterface, ReplaceMissingKeyInterface
{

}

abstract class MyCollection implements MyCollectionInterface
{
    use CollectionInterfaceTrait;
    use KeyFilterInterfaceTrait;
    use RemovableInterfaceTrait;
    use ReplaceByKeyInterfaceTrait;
    use ReplaceEqualValueInterfaceTrait;
    use UnshiftInterfaceTrait;
    use BeforeReplaceInterfaceTrait;
    use ReplaceMissingKeyInterfaceTrait;
}

abstract class MyChildCollection extends MyCollection implements AppendableInterface
{
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use HasDuplicateKeyVerificationInterfaceTrait;
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

echo "Replace item with key: 'lol' (not exists) and value: 'something', it has append to the collection\n";
try{
    $collection->replaceByKey('something', 'lol');
}catch(\Exception $e){
    echo "EXCEPTION: {$e->getMessage()}\n";
}


echo "Check items in the collection\n";

foreach($collection as $value){
    echo "Item: $value\n";
}

echo "Add item: 'first' at the beginning\n";

$collection->unshift('first');

echo "Get first item: {$collection->getFirst()}\n";