<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\NullResolverInterface;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\BeforeAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\BeforeRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;

class NullResolverCollection implements NullResolverCollectionInterface
{
    use CollectionInterfaceTrait;
    use LockableObjectInterfaceTrait;
    use BeforeAppendInterfaceTrait;
    use AppendManyTrait;
    use LockAppendInterfaceTrait;
    use BeforeRemoveInterfaceTrait;
    use RemovableInterfaceTrait;
    use LockRemoveInterfaceTrait;

    /**
     * @var IntegerKeyResolver
     */
    private $keyResolver;

    public function __construct(iterable $items=null)
    {
        $this->keyResolver = new IntegerKeyResolver();

        if(null !== $items){
            $this->appendMany($items);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function append($item, $key = null): CollectionInterface
    {
        if(!$item instanceof NullResolverInterface) {
            $msg = sprintf(
                'Given item is not an instance of "%s", "%s" was given',
                NullResolverInterface::class,
                is_object($item) ? get_class($item) : gettype($item)
            );

            throw new \InvalidArgumentException($msg);
        }

        $this->setItem($item, $this->keyResolver->resolveNull($this, null));
        $this->setCount($this->count() + 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveNull(CollectionInterface $collection, $key, ...$params)
    {
        $val = null;

        /**
         * @var NullResolverInterface $resolver
         */
        foreach($this as $resolver){
            $val = $resolver->resolveNull($collection, $key, ...$params);
        }

        return $val;
    }
}