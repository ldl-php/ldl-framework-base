<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\RemoveByEqualValueInterface;
use LDL\Framework\Base\Collection\Traits\RemoveByEqualValueInterfaceTrait;

class AppendableExample implements CollectionInterface, AppendableInterface, RemoveByKeyInterface, RemoveByEqualValueInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemoveByKeyInterfaceTrait;
    use RemoveByEqualValueInterfaceTrait;
}

echo "Create collection\n";

$collection = new AppendableExample();

echo "Append items: 'a','b'\n";

$collection->appendMany(['test'=>'a','b'], true);

$collection->appendMany(['test'=>'y'], true);

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item 'c' with key 4\n";

$collection->append('c', 4);

echo "Append items: 'd','e'\n";

$collection->appendMany(['d','e'], true);

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove first item\n";

$collection->removeByKey(0);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'f'\n";

$collection->append('f');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append items: 'g','h','i'\n";

$collection->appendMany(['g','h','i']);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove item 'h'\n";

$collection->removeByEqualValue('h');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append items: 'h','i'\n";

$collection->appendMany(['h','i']);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove last ('i')\n";

$collection->removeLast();

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'i'\n";

$collection->append('i');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove 'b','c','f'\n";

$collection->removeByKey(1);
$collection->removeByKey(4);
$collection->removeByKey(7);

echo "Number of items: ".$collection->count()."\n";

echo "Append item: 'L', with string as key\n";

$collection->append('L', 'stringKey');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'j'\n";

$collection->append('j');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}
