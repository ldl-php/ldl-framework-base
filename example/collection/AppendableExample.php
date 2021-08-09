<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Base\Collection\Contracts\HasDuplicateKeyVerificationAppendInterface;
use LDL\Framework\Base\Collection\Traits\HasDuplicateKeyVerificationAppendInterfaceTrait;


class AppendableExample implements CollectionInterface, AppendableInterface, RemovableInterface, HasDuplicateKeyVerificationAppendInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait;
    use AppendManyTrait;
    use RemovableInterfaceTrait;
    use HasDuplicateKeyVerificationAppendInterfaceTrait;

    public function __construct()
    {
        $this->onAppendDuplicateKey()->append(function($v, $key){
            $keys = $this->keys();

            $keys = IterableHelper::filter($keys, static function($k){
                return is_int($k);
            });

            /**
             * No integer key was found it so 0 is the greater
             */
            if(count($keys) === 0){
                return 0;
            }

            usort($keys, function($a, $b){
                return $a > $b;
            });

            return $keys[count($keys)-1] + 1;
        });
    }
}

echo "Create collection\n";

$collection = new AppendableExample();

echo "Append items: 'a','b' with keys 0, 1\n";

$collection->appendMany(['a','b'], true);

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item 'c' with key 4\n";

$collection->append('c', 4);

echo "Append items: 'd','e' with keys 5, 6\n";

$collection->appendMany(['d','e'], true);

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove first item\n";

$collection->remove(0);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'f'\n";

$collection->append('f');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append items: 'g','h','i'\n";

$collection->appendMany(['g','h','i']);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove item 'h'\n";

$collection->removeByValue('h');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append items: 'h','i'\n";

$collection->appendMany(['h','i']);

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove last ('i')\n";

$collection->removeLast();

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'i'\n";

$collection->append('i');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Remove 'b','c','f'\n";

$collection->remove(1);
$collection->remove(4);
$collection->remove(7);

echo "Number of items: ".$collection->count()."\n";

echo "Append item: 'L', with string as key\n";

$collection->append('L', 'stringKey');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}

echo "Append item: 'j'\n";

$collection->append('j');

echo "Number of items: ".$collection->count()."\n";

echo "Check items\n";

foreach($collection as $key => $item){
    echo "Key: ".$key." - Item: ".$item."\n";
}