<?php declare(strict_types=1);

use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\AppendBeforeKeyInterface;
use LDL\Framework\Base\Collection\Traits\AppendBeforeKeyInterfaceTrait;

require __DIR__.'/../../vendor/autoload.php';

class AppendBeforeKeyExample implements CollectionInterface, AppendableInterface, AppendBeforeKeyInterface
{
    use AppendManyTrait,
        AppendableInterfaceTrait,
        CollectionInterfaceTrait,
        AppendBeforeKeyInterfaceTrait;
}


$collection = new AppendBeforeKeyExample();

$items = [
    100,
    new \stdClass,
    "int" => 500,
    "class" => new \stdClass,
    new \stdClass
];

echo "\nAppend following items to collection\n";

echo var_export($items, true)."\n";

$collection->appendMany($items, true);

echo "\nAppend a new item before key '2', with key 'new-class', 'new-class' must be shown before '2'\n";

$collection->appendBeforeKey(new \stdClass, 2, 'new-class');

echo var_export(iterator_to_array($collection, true), true) . "\n";