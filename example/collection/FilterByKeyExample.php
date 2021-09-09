<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\KeyFilterInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\KeyFilterInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Exception\CollectionException;

interface FilterByKeyExampleInterface extends CollectionInterface, AppendableInterface, KeyFilterInterface
{

}

class FilterByKeyExample implements FilterByKeyExampleInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use KeyFilterInterfaceTrait;
}

echo "Create collection with the following keys and values:\n\n";

$items = [
    'test1' => 'a',
    'test2' => 'b',
    'test3' => 'c',
    'test4' => 'd',
    'testAR' => 'e'
];

echo var_export($items, true)."\n\n";

$collection = new FilterByKeyExample();

$collection->appendMany($items, true);

echo "Filter by keys test1 and test2:\n\n";

echo "Result:\n\n";
echo var_export($collection->filterByKeys(['test1', 'test2'])->keys(), true);

echo "Filter by key test3 and output it's value (c):\n\n";

echo $collection->filterByKey('test3')."\n\n";

echo "Filter by key test22 (exception must be thrown):\n\n";

try {
    var_dump($collection->filterByKey('test22'));
}catch(CollectionException $e){
    echo "EXCEPTION: {$e->getMessage()}\n\n";
}

echo "Filter by regex test[0-9]+ (all elements except testAR must show up):\n\n";

foreach($collection->filterByKeyRegex('/test[0-9+]/') as $key => $value){
    echo $key."\n";
}
