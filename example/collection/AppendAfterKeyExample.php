<?php declare(strict_types=1);

use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\AppendAfterKeyInterface;
use LDL\Framework\Base\Collection\Traits\AppendAfterKeyInterfaceTrait;

require __DIR__.'/../../vendor/autoload.php';

class AppendAfterKeyExample implements CollectionInterface, AppendableInterface, AppendAfterKeyInterface
{
    use AppendManyTrait,
        AppendableInterfaceTrait,
        CollectionInterfaceTrait,
        AppendAfterKeyInterfaceTrait;
}

$collection = new AppendAfterKeyExample();

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

echo "\nAppend a new item after key 'class', with key 'new-class', 'new-class' must be shown after 'class'\n";

$collection->appendAfterKey(new \stdClass, "class", 'new-class');

echo var_export(iterator_to_array($collection, true), true) . "\n";


