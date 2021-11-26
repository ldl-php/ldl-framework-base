<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\SortByKeyInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\SortByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;

class Collection implements CollectionInterface, AppendableInterface, SortByKeyInterface
{
    use AppendManyTrait,
        SortByKeyInterfaceTrait,
        CollectionInterfaceTrait,
        AppendableInterfaceTrait;
}

echo "Create new Collection class instance\n";
$collection = new Collection();

$items = [5 => 2, 1 => 'a', 'three' => 'e', 2 => 1, 'four' => 5, 'class' => new \stdClass];

echo "\nAppend items:\n";

echo var_export($items, true)."\n";

$collection->appendMany($items, true);

echo "\nSort by key ascending:\n";

echo var_export(iterator_to_array($collection->ksort(Constants::SORT_ASCENDING)), true) . "\n";

echo "\nSort by key descending:\n";

echo var_export(iterator_to_array($collection->ksort(Constants::SORT_DESCENDING)), true) . "\n";