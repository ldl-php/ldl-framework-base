<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;

class CallableCollection implements CallableCollectionInterface
{
    use AppendableInterfaceTrait {append as private _append;}
    use CollectionInterfaceTrait;
    use AppendManyTrait;
    use LockAppendInterfaceTrait;
    use RemovableInterfaceTrait;
    use LockRemoveInterfaceTrait;
    use LockableObjectInterfaceTrait;

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
            throw new \InvalidArgumentException($msg);
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
