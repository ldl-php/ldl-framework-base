<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Exception\InvalidArgumentException;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\AppendInPositionInterface;
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

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

echo "Append 1 in first position (top of collection)\n";

$collection->appendInPosition(
    'first (I will be second at the end of this example)',
    AppendInPositionInterface::APPEND_POSITION_FIRST
);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

echo "First key is: {$collection->getFirstKey()}\n";
echo "Last key is: {$collection->getLastKey()}\n";

echo "Append in same position (3) with the same index:\n\n";

$collection->appendInPosition(
    'I must be below',
    3,
    'string_index_3rd'
);

$collection->appendInPosition(
    'I must be above',
    3,
    'string_index_3rd'
);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

echo "First key is: {$collection->getFirstKey()}\n";
echo "Last key is: {$collection->getLastKey()}\n";

echo "Try to pass an invalid negative position (-20)\n";

try {
    $collection->appendInPosition('400', -20);
}catch(InvalidArgumentException $e){
    echo "OK: {$e->getMessage()}\n";
}

echo "Try to pass a non existing position\n";
try{
    $collection->appendInPosition('500', 1000);
}catch(InvalidArgumentException $e){
    echo "OK: {$e->getMessage()}\n";
}

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

$collection->appendInPosition(
    'I must be above the two',
    3,
    'string_index_3rd'
);

echo "Append an item in the last position:\n\n";

$collection->appendInPosition(
    'In last position',
    AppendInPositionInterface::APPEND_POSITION_LAST
);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

echo "Append an item to the top of the collection:\n\n";

$collection->appendInPosition('I must be on top',1);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

$collection->appendManyInPosition(['key_1'=>20,'key_2'=>21,'key_3'=>22], 1);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";