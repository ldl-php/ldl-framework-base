<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;

class CollectionExample implements CollectionInterface, AppendableInterface, RemoveByKeyInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemoveByKeyInterfaceTrait;
}

echo "Create collection\n";

$collection = new CollectionExample();

echo "Append many uniqid's with the same key: '1.1'\n";
$collection->append(uniqid('', true),'1.1');
$collection->append(uniqid('', true),'1.1');
$collection->append(uniqid('', true),'1.1');
$collection->append(uniqid('', true));

echo "Check items in the collection\n";

echo var_export(\iterator_to_array($collection, true), true)."\n\n";
