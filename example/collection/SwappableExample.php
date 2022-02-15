<?php

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\SwappableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Traits\SwappableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;


class SwappableExample implements CollectionInterface, AppendableInterface, SwappableInterface
{
    use SwappableInterfaceTrait;
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
}

echo "Create Collection \n";
$collection = new SwappableExample();
$items = [
    'test' => 'a',
    'b'
];

echo "Append items: \n\n";
echo var_export($items, true)."\n\n";
$collection->appendMany($items, true);
$collection->swap(0, 1);
echo var_export(iterator_to_array($collection, true))."\n";
