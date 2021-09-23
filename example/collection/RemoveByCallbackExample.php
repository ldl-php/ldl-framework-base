<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Traits\BeforeRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\RemoveByCallbackInterface;
use LDL\Framework\Base\Collection\Traits\RemoveByCallbackTrait;

interface RemoveByCallbackExampleInterface extends CollectionInterface, RemoveByCallbackInterface, BeforeRemoveInterface
{

}

class RemoveByCallbackExample implements RemoveByCallbackExampleInterface
{
    use CollectionInterfaceTrait;
    use RemoveByCallbackTrait;
    use BeforeRemoveInterfaceTrait;

    public function __construct(iterable $items)
    {
        $this->setItems($items);
        $this->getBeforeRemove()->append(static function($collection, $item, $key){
            echo "\n\n#####################################################\n";
           echo "Trigger on before remove: $key => $item\n";
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

$collection = new RemoveByCallbackExample($items);

echo "Remove items where value is equal to 'LDL'\n";
$count = $collection->removeByCallback(static function($val) : bool {
    return 'LDL' === $val;
});

echo "Removed $count items!\n\n";

echo var_export(\iterator_to_array($collection, true), true)."\n\n";