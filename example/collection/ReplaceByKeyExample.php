<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Base\Collection\Traits\BeforeReplaceInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\ReplaceByKeyInterface;
use LDL\Framework\Base\Collection\Traits\ReplaceByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\HasDuplicateKeyResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\Traits\HasDuplicateKeyResolverInterfaceTrait;

interface ReplaceByKeyExampleInterface extends CollectionInterface, ReplaceByKeyInterface, BeforeReplaceInterface
{

}

class ReplaceByKeysExample implements ReplaceByKeyExampleInterface, HasDuplicateKeyResolverInterface
{
    use CollectionInterfaceTrait;
    use ReplaceByKeyInterfaceTrait;
    use BeforeReplaceInterfaceTrait;
    use HasDuplicateKeyResolverInterfaceTrait;

    public function __construct(iterable $items)
    {
        $this->setItems($items);
        $this->getDuplicateKeyResolver()->append(new \LDL\Framework\Base\Collection\Resolver\Key\StringKeyResolver());
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

$collection = new ReplaceByKeysExample($items);

echo "Replace key 'second' with key 'third' and value 'second_replaced'\n";
echo "Since there is already a key 'third', default key resolver must kick in and transform third into third_1\n";

$collection->replaceByKey('second','third','second_replaced');

echo var_export(\iterator_to_array($collection, true), true)."\n\n";