<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Traits\BeforeReplaceInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\ReplaceByCallbackInterface;
use LDL\Framework\Base\Collection\Traits\ReplaceByCallbackTrait;

interface ReplaceByCallbackExampleInterface extends CollectionInterface, ReplaceByCallbackInterface, BeforeReplaceInterface
{

}

class ReplaceByCallbackExample implements ReplaceByCallbackExampleInterface
{
    use CollectionInterfaceTrait;
    use ReplaceByCallbackTrait;
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

$collection = new ReplaceByCallbackExample($items);

echo "Replace item with value 'LDL' with 'REPLACE_BY_CALLBACK'\n";
$collection->replaceByCallback(static function($val, $key) : bool {
    return 'LDL' === $val;
}, 'REPLACE_BY_CALLBACK');

echo var_export(\iterator_to_array($collection, true), true)."\n\n";