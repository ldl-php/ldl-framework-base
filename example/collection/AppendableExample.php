<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;


class AppendableExample implements CollectionInterface, AppendableInterface, RemovableInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemovableInterfaceTrait;
}

echo "Create collection\n";

$collection = new AppendableExample();

echo "Append items: 'a','b'\n";

$collection->appendMany(['a','b']);

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove first item\n";

$collection->remove(0);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'c'\n";

$collection->append('c');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append items: 'd','e','f'\n";

$collection->appendMany(['d','e','f']);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove item 'e'\n";

$collection->removeByValue('e');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append items: 'e','f'\n";

$collection->appendMany(['e','f']);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove last ('f')\n";

$collection->removeLast();

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

echo "Remove 'b','c','f'\n";

$collection->remove(1);
$collection->remove(2);
$collection->remove(5);

echo "Number of items: ".$collection->count()."\n";

echo "Append item: 'g', with string as key\n";

$collection->append('g', 'stringKey');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'h'\n";

$collection->append('h');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}