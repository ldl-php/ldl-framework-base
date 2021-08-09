<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\HasDuplicateKeyVerificationInterface;
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
use LDL\Framework\Base\Collection\Traits\HasDuplicateKeyVerificationInterfaceTrait;

interface MyCollectionInterface extends CollectionInterface, KeyFilterInterface, RemovableInterface, ReplaceableInterface, UnshiftInterface
{

}

abstract class MyCollection implements MyCollectionInterface
{
    use CollectionInterfaceTrait;
    use KeyFilterInterfaceTrait;
    use RemovableInterfaceTrait;
    use ReplaceableInterfaceTrait;
    use UnshiftInterfaceTrait;
}

abstract class MyChildCollection extends MyCollection implements AppendableInterface, HasDuplicateKeyVerificationInterface
{
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use HasDuplicateKeyVerificationInterfaceTrait;
}

class MyAppendableCollection extends MyChildCollection
{
    public function __construct()
    {
        $this->onDuplicateKey()->append(function($v, $k){
            return $this->append($v, $k);
        });
    }
}

echo "Create collection\n";

$collection = new MyAppendableCollection();

echo "Append single item: 'hello'\n";

$collection->append('hello');

echo "Get value at offset 0\n";

var_dump($collection->get(0));

echo "Append many items: 'LDL', 'World'\n";

$collection->appendMany(['LDL', 'World']);

echo "Check items in the collection\n";

foreach($collection as $value){
    echo "Item: $value\n";
}

echo "Replace item 'LDL' with 'crazy'\n";

$collection->replace('crazy', 1);

echo "Check items in the collection\n";

foreach($collection as $value){
    echo "Item: $value\n";
}

echo "Replace item with key: 'lol' (not exists) and value: 'something', it has append to the collection\n";
$collection->replace('something', 'lol');

echo "Check items in the collection\n";

foreach($collection as $value){
    echo "Item: $value\n";
}

echo "Add item: 'first' at the beginning\n";

$collection->unshift('first');

echo "Get first item: {$collection->getFirst()}\n";