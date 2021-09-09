<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Traits\BeforeReplaceInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\ReplaceByValueInterface;
use LDL\Framework\Base\Collection\Traits\ReplaceByValueInterfaceTrait;

interface ReplaceByValueExampleInterface extends CollectionInterface, ReplaceByValueInterface, BeforeReplaceInterface
{

}

class ReplaceByValueExample implements ReplaceByValueExampleInterface
{
    use CollectionInterfaceTrait;
    use ReplaceByValueInterfaceTrait;
    use BeforeReplaceInterfaceTrait;

    public function __construct(iterable $items)
    {
        $this->setItems($items);
        $this->getBeforeReplace()->append(static function($collection, $item, $key){
            echo "\n\n#####################################################\n";
           echo "Trigger on before replace: $key => $item\n";
            echo "#####################################################\n\n";
        });
    }
}

echo "Create collection\n";

$items = [
    'first'  => 'Hello',
    'second' => 'LDL',
    'third'  => 'LDL',
    'last'   => 'World'
];

echo "Create collection with items:\n\n";
echo var_export($items, true)."\n\n";

$collection = new ReplaceByValueExample($items);

echo "Check items in the collection:\n\n";
echo var_export(\iterator_to_array($collection, true), true)."\n\n";

echo "Replace item with value 'World' with 'REPLACED_WORLD'\n";

$collection->replaceByValue('World', 'REPLACED_WORLD');

echo "Replace items with value 'LDL' with 'REPLACED_LDL'\n";
$collection->replaceByValue('LDL', 'REPLACED_LDL');

echo var_export(\iterator_to_array($collection, true), true)."\n\n";