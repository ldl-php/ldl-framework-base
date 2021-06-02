<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\UnshiftInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\UnshiftInterfaceTrait;

class UnshiftExample implements CollectionInterface, AppendableInterface, UnshiftInterface
{
    use CollectionInterfaceTrait;
    use AppendManyTrait;
    use AppendableInterfaceTrait;
    use UnshiftInterfaceTrait;
}

echo "Create UnshiftCollection\n";

$collection = new UnshiftExample();

echo "Append many: 2,3,4,5\n";

$collection->appendMany([2,3,4,5]);

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

echo "Unshift: 1\n";

$collection->unshift(1);

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

echo "--------------------------------\n";

echo "Create another UnshiftCollection\n";

$collection = new UnshiftExample();

echo "Append: 2,'third',4,'fifth' with keys: 'second',null,'fourth',null respectively\n";

$collection->append(2, 'second');
$collection->append('third');
$collection->append(4,'fourth');
$collection->append('fifth');

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

echo "Unshift: 1 with key 'first'\n";

$collection->unshift(1,'first');

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}
