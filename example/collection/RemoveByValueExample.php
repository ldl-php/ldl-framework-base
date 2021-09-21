<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemoveByKeyInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Contracts\RemoveByValueInterface;
use LDL\Framework\Base\Collection\Traits\RemoveByValueInterfaceTrait;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Helper\IterableHelper;

class RemoveByValueExample implements CollectionInterface, AppendableInterface, RemoveByKeyInterface, RemoveByValueInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemoveByKeyInterfaceTrait;
    use RemoveByValueInterfaceTrait;
}

echo "Create collection\n";

$collection = new RemoveByValueExample();

$items = [
    'test' => 'a',
    'b',
    'c',
    'd',
    'e',
    'f',
    'g'
];

echo "Append items:\n\n";
echo var_export($items,true)."\n\n";
$collection->appendMany($items, true);

echo "Remove where value > 'd' (e,f and g must be removed):\n\n";
$collection->removeByValue('d',ComparisonOperatorHelper::OPERATOR_GT);

echo var_export(IterableHelper::toArray($collection), true)."\n\n";

echo "Remove where value < 'd' (c, b and a must be removed):\n\n";
$collection->removeByValue('d',ComparisonOperatorHelper::OPERATOR_LT);

echo var_export(IterableHelper::toArray($collection), true)."\n\n";

echo "Remove where value === 'd' (Empty array must be displayed):\n\n";
$collection->removeByValue('d',ComparisonOperatorHelper::OPERATOR_SEQ);

echo var_export(IterableHelper::toArray($collection), true);