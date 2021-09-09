<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;

class AppendableExample implements CollectionInterface, AppendableInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
}

echo "Create collection\n";

$collection = new AppendableExample();

$items = [
  'test' => 'a',
  'b'
];

echo "Append items:\n\n";
echo var_export($items,true)."\n\n";
$collection->appendMany($items, true);

$items = [
    'test' => 'y'
];

echo "Append item with duplicate key 'test', key must be resolved to a different key (test_1):\n\n";

$collection->appendMany($items, true);
echo var_export(\iterator_to_array($collection,true), true);
