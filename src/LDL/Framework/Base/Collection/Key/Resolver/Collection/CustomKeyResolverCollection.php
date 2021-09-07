<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\DuplicateResolverInterface;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\BeforeAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\BeforeRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;

class CustomKeyResolverCollection implements DuplicateResolverCollectionInterface
{
    use CollectionInterfaceTrait;
    use LockableObjectInterfaceTrait;
    use BeforeAppendInterfaceTrait;
    use AppendManyTrait;
    use LockAppendInterfaceTrait;
    use BeforeRemoveInterfaceTrait;
    use RemovableInterfaceTrait;
    use LockRemoveInterfaceTrait;

    public function __construct(iterable $items=null)
    {
        if(null !== $items){
            $this->appendMany($items);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function append($item, $key = null): CollectionInterface
    {
        if(!$item instanceof DuplicateResolverInterface) {
            $msg = sprintf(
                'Given item is not an instance of "%s", "%s" was given',
                DuplicateResolverInterface::class,
                is_object($item) ? get_class($item) : gettype($item)
            );

            throw new \InvalidArgumentException($msg);
        }

        $this->setItem($item, (new AutoIncrementKeyResolver())->resolve($this, $key, null));
        $this->setCount($this->count() + 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveDuplicate(CollectionInterface $collection, $key, $value=null, ...$params)
    {
        $val = null;

        /**
         * @var DuplicateResolverCollectionInterface $resolver
         */
        foreach($this as $resolver){
            $val = $resolver->resolveDuplicate($collection, $key, $value, ...$params);
        }

        return $val;
    }
}