<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection;

use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Exception\InvalidArgumentException;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\SortByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\CallableCollectionSortedInterface;
use LDL\Framework\Base\Collection\Traits\CallableCollectionSortedInterfaceTrait;

class CallableCollection implements CallableCollectionInterface, CallableCollectionSortedInterface
{
    use AppendableInterfaceTrait {append as private _append;}
    use CollectionInterfaceTrait;
    use AppendManyTrait;
    use LockAppendInterfaceTrait;
    use RemoveByKeyInterfaceTrait;
    use LockRemoveInterfaceTrait;
    use LockableObjectInterfaceTrait;
    use SortByKeyInterfaceTrait;
    use CallableCollectionSortedInterfaceTrait;

    public function __construct(iterable $items=null)
    {
        if(null !== $items){
            $this->appendMany($items);
        }
    }

    public function append($item, $key = null): CollectionInterface
    {
        if(!$item instanceof \Closure){
            $msg = sprintf('Item to be added must be an instance of %s', \Closure::class);
            throw new InvalidArgumentException($msg);
        }

        return $this->_append($item, $key);
    }

    public function call(...$params) : void
    {
        /**
         * @var \Closure $closure
         */
        foreach($this as $closure){
            $closure(...$params);
        }
    }

    public function callByRef(&...$params): void
    {
        /**
         * @var \Closure $closure
         */
        foreach($this as $closure){
            $closure(...$params);
        }
    }
}
