<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\BeforeAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;

class ArrayKeyCollection implements ArrayKeyCollectionInterface
{
    use CollectionInterfaceTrait;
    use AppendableInterfaceTrait {append as private _append;}
    use AppendManyTrait;
    use LockAppendInterfaceTrait;
    use RemovableInterfaceTrait;
    use LockRemoveInterfaceTrait;
    use LockableObjectInterfaceTrait;
    use BeforeAppendInterfaceTrait;

    public function __construct(iterable $items=null)
    {
        $this->getBeforeAppendKey()->append(static function($collection, $item, $key){
            ArrayHelper::validateKey($key);
        });

        if(null !== $items){
            $this->appendMany($items);
        }
    }
}
