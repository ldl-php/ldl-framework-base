<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByNameInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\FilterByNameTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Contracts\NameableInterface;

class NameableClass1 implements NameableInterface
{
    public function getName(): string
    {
        return 'Name1';
    }
}

class NameableClass2 implements NameableInterface
{
    public function getName(): string
    {
        return 'Name2';
    }
}

class FilterByNameCollection implements CollectionInterface, AppendableInterface, FilterByNameInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use FilterByNameTrait;
}

echo "Create new Nameable collection class instance\n";
$collection = new FilterByNameCollection();

echo "Append NameableClass1\n";
$collection->append(new NameableClass1());

echo "Append NameableClass2\n";
$collection->append(new NameableClass2());

echo "Filter by name: Name1\n";
echo "Found ".count($collection->filterByName('Name1'))." elements \n";

echo "Filter by namespace regex: #.*2$#\n";
echo "Found ".count($collection->filterByNameRegex('#.*2$#'))." elements \n";

echo "Filter by namespace regex: #Name.*$#\n";
echo "Found ".count($collection->filterByNameRegex('#Name.*$#'))." elements \n";

echo "Filter by names: [Name1, Name2]\n";
echo "Found ".count($collection->filterByNames(['Name1', 'Name2']))." elements \n";

echo "Auto validate\n";


echo "Filter by name in Auto mode: Name1\n";
echo "Found ".count($collection->filterByNameAuto('Name1'))." elements \n";

echo "Filter by namespace regex in Auto mode: #.*2$#\n";
echo "Found ".count($collection->filterByNameAuto('#.*2$#'))." elements \n";

echo "Filter by namespace regex in Auto mode: #Name.*$#\n";
echo "Found ".count($collection->filterByNameAuto('#Name.*$#'))." elements \n";

echo "Filter by names: [Name1, Name2] in Auto mode\n";
echo "Found ".count($collection->filterByNameAuto(['Name1', 'Name2']))." elements \n";