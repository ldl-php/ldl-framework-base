<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\SortInterface;
use LDL\Framework\Base\Collection\Exception\SortException;
use LDL\Framework\Base\Collection\Traits\SortInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\HasSortValueInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;

class Collection implements CollectionInterface, AppendableInterface, SortInterface
{
    use AppendManyTrait,
        SortInterfaceTrait,
        CollectionInterfaceTrait,
        AppendableInterfaceTrait;
}

class T implements HasSortValueInterface
{
    protected $property = 56;

    public function getSortValue()
    {
        return $this->property;
    }
}

class T1 implements HasSortValueInterface
{
    protected $property = 6;

    public function getSortValue()
    {
        return $this->property;
    }
}

class T2 implements HasSortValueInterface
{
    protected $property = "a";

    public function getSortValue()
    {
        return $this->property;
    }
}

echo "Create new Collection class instance\n";
$collection = new Collection();

$items = [2,'a','e',1,5,'b','d',3,'c',4];

echo "\nAppend items:\n";

echo var_export($items, true)."\n";

$collection->appendMany($items);

echo "\nSort ascending:\n";

foreach ($collection->sort(Constants::SORT_ASCENDING) as $key => $item) {
    echo $item . "\n";
}

echo "\nSort descending:\n";

foreach ($collection->sort(Constants::SORT_DESCENDING) as $key => $item) {
    echo $item . "\n";
}

echo "\nCreate new Collection class instance\n";
$collection = new Collection();

$collection->appendMany([
    new T,
    34,
    new T1,
    1000,
    new T2
]);

echo "\nSort items with property in ascending:\n";

echo var_export(iterator_to_array($collection->sort()), true) . "\n";

echo "\nSort items with property in descending:\n";

echo var_export(iterator_to_array($collection->sort(Constants::SORT_DESCENDING)), true) . "\n";

try {
    echo "\nAppend an object which does NOT implements HasSortValueInterface (EXCEPTION must be thrown)\n";
    $collection->append(new \stdClass());
    $collection->sort();
} catch (SortException $e) {
    echo "OK Exception {$e->getMessage()}\n";
}