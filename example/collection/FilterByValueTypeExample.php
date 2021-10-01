<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\FilterByValueTypeInterface;
use LDL\Framework\Base\Collection\Traits\FilterByValueTypeInterfaceTrait;

interface FilterByValueTypeExampleInterface extends CollectionInterface, FilterByValueTypeInterface
{

}

class FilterByValueTypeExampleCollection implements FilterByValueTypeExampleInterface, \LDL\Framework\Base\Contracts\LockableObjectInterface
{
    use CollectionInterfaceTrait;
    use FilterByValueTypeInterfaceTrait;
    use \LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;

    public function __construct(iterable $items)
    {
        $this->setItems($items);
    }

}
echo "Create collection FilterByValueTypeExampleCollection: \n\n";

$collection = new FilterByValueTypeExampleCollection([
    1,
    2,
    3,
    'hello',
    'world',
    [ 'a', 'b', 'c'],
    new \stdClass
]);

echo var_export($collection->toArray(), true)."\n\n";

echo "Filter strings in mixed collection:\n\n";
echo var_export($collection->filterByValueType('string')->toArray(), true)."\n\n";

echo "Filter integers in mixed collection:\n\n";
echo var_export($collection->filterByValueType('integer')->toArray(), true)."\n\n";

echo "Filter objects in mixed collection:\n\n";
echo var_export($collection->filterByValueType('object')->toArray(), true)."\n\n";

echo "Filter arrays in mixed collection:\n\n";
echo var_export($collection->filterByValueType('array')->toArray(), true)."\n\n";

