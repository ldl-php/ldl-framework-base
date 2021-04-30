<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\FilterByNamespaceInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\FilterByNamespaceInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Contracts\NamespaceInterface;

class NamespaceClass1 implements NamespaceInterface
{
    public function getNamespace(): string
    {
        return 'Namespace 1';
    }

    public function getName(): string
    {
        return 'Name';
    }
}

class NamespaceClass2 implements NamespaceInterface
{
    public function getNamespace(): string
    {
        return 'Namespace 2';
    }

    public function getName(): string
    {
        return 'Name';
    }
}

class FilterByNamespaceCollection implements CollectionInterface, AppendableInterface, FilterByNamespaceInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use FilterByNamespaceInterfaceTrait;
}

echo "Create new Nameable collection class instance\n";
$collection = new FilterByNamespaceCollection();

echo "Append NamespaceClass1\n";
$collection->append(new NamespaceClass1());

echo "Append NamespaceClass2\n";
$collection->append(new NamespaceClass2());

echo "Filter by namespace regex: #.*2$#\n";
echo "Found ".count($collection->filterByNamespaceRegex('#.*2#'))." elements \n";

echo "Filter by namespace: \"Namespace 1\"\n";
echo "Found ".count($collection->filterByNamespace('Namespace 1'))." elements \n";

echo "Filter by namespaces: [Namespace1, Namespace2]\n";
echo "Found ".count($collection->filterByNamespaces(['Namespace 1', 'Namespace 2']))." elements \n";

echo "Filter by namespace and name: Namespace 1, Name\n";
echo "Found ".count($collection->filterByNamespaceAndName('Namespace 1', 'Name'))." elements \n";

echo "\nAuto filter:\n\n";

echo "Filter by namespace: \"Namespace 1\" in Auto mode\n";
echo "Found ".count($collection->filterByNamespaceAuto('Namespace 1'))." elements \n";

echo "Filter by regex #.*2# in Auto mode:\n";
echo "Found ".count($collection->filterByNamespaceAuto('#.*2#'))." elements \n";

echo "Filter by namespaces: [Namespace 1, Namespace 2] in Auto mode\n";
echo "Found ".count($collection->filterByNamespaceAuto(['Namespace 1', 'Namespace 2']))." elements \n";