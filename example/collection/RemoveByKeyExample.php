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
use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Helper\IterableHelper;

class RemoveByKeyExample implements CollectionInterface, AppendableInterface, RemoveByKeyInterface, RemoveByValueInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemoveByKeyInterfaceTrait;
    use RemoveByValueInterfaceTrait;
}

echo "Create collection\n";

$collection = new RemoveByKeyExample();

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

echo "Remove where key > 3 (Keys 4 and 5 must be removed):\n\n";
$collection->removeByKey(3,Constants::OPERATOR_GT);

echo var_export(IterableHelper::toArray($collection), true)."\n\n";

echo "Remove where key <= 1 (Keys 0, 1 and test must be removed):\n\n";
$collection->removeByKey(1, Constants::OPERATOR_LTE);

echo var_export(IterableHelper::toArray($collection), true)."\n\n";

echo "Remove where key !== 2 (Key 3 must be removed):\n\n";
$collection->removeByKey(2,Constants::OPERATOR_NOT_SEQ);

echo var_export(IterableHelper::toArray($collection), true);