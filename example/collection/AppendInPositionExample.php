<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\AppendInPositionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendInPositionInterfaceTrait;

class AppendInPositionExample implements CollectionInterface, AppendableInterface, AppendInPositionInterface
{
    use CollectionInterfaceTrait;
    use AppendManyTrait;
    use AppendableInterfaceTrait;
    use AppendInPositionInterfaceTrait;
}

echo "Create AppendInPositionExample\n";

$collection = new AppendInPositionExample();

echo "Append many: 2,3,4,5\n";

$collection->appendMany([2,3,4,5]);

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

echo "Append 1 in first position (top of collection)\n";

$collection->appendInPosition(
    1,
    AppendInPositionInterface::APPEND_POSITION_FIRST
);

echo "Check items in the collection\n";

foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

echo "First key is: {$collection->getFirstKey()}\n";
echo "Last key is: {$collection->getLastKey()}\n";

$collection->appendInPosition(
    'In 3rd position',
    3,
    'string_index_3rd'
);

$collection->appendInPosition(
    'In 3rd position (duplicate)',
    3,
    'string_index_3rd'
);

echo "Check items in the collection\n";

foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

echo "First key is: {$collection->getFirstKey()}\n";
echo "Last key is: {$collection->getLastKey()}\n";

echo "Try to pass an invalid negative position (-20)\n";

try {
    $collection->appendInPosition('400', -20);
}catch(\InvalidArgumentException $e){
    echo "OK: {$e->getMessage()}\n";
}

echo "Try to pass a non existing position\n";
try{
    $collection->appendInPosition('500', 1000);
}catch(\InvalidArgumentException $e){
    echo "OK: {$e->getMessage()}\n";
}

echo "Check items in the collection\n";

foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}

$collection->appendInPosition(
    'In 3rd position',
    3,
    'string_index_3rd_copy'
);

$collection->appendInPosition(
    'In last position',
    10
);



echo "Check items in the collection\n";

foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}


echo "#############################################\n";
$collection->appendInPosition('999',1);


foreach($collection as $key => $value){
    echo "Key: $key, Item: $value\n";
}
