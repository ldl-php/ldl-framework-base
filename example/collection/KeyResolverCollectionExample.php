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

$collection = new CollectionExample();

$collection->append(uniqid('', true),'1.1');
$collection->append(uniqid('', true),'1.1');
$collection->append(uniqid('', true),'1.1');
$collection->append(uniqid('', true));

foreach($collection as $k=>$v){
    echo $k."\n";
}
