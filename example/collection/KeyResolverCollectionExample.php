<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts\HasKeyResolverInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Traits\HasKeyResolverInterfaceTrait;
use LDL\Framework\Helper\ClassHelper;

class CollectionExample implements CollectionInterface, AppendableInterface, RemovableInterface, HasKeyResolverInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemovableInterfaceTrait;
    use HasKeyResolverInterfaceTrait;
}

try {
    $collection = new CollectionExample();

    $collection->append(uniqid('', true), 1.1);
    $collection->append(uniqid('', true), 1.1);
}catch(\Exception $e){
    echo $e->getMessage()."\n";
    echo $e->getTraceAsString();
    die();
}

foreach($collection as $k=>$v){
    echo $k."\n";
}

