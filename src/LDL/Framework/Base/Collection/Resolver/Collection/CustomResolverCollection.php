<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Resolver\Contracts\CustomResolverInterface;
use LDL\Framework\Base\Collection\Resolver\Key\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\BeforeAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\BeforeRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemoveByKeyInterfaceTrait;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;

class CustomResolverCollection implements CustomResolverCollectionInterface
{
    use CollectionInterfaceTrait;
    use LockableObjectInterfaceTrait;
    use BeforeAppendInterfaceTrait;
    use AppendManyTrait;
    use LockAppendInterfaceTrait;
    use BeforeRemoveInterfaceTrait;
    use RemoveByKeyInterfaceTrait;
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
        if(!$item instanceof CustomResolverInterface) {
            $msg = sprintf(
                'Given item is not an instance of "%s", "%s" was given',
                CustomResolverInterface::class,
                is_object($item) ? get_class($item) : gettype($item)
            );

            throw new \InvalidArgumentException($msg);
        }

        $this->setItem($item, $this->keyResolver->resolveCustom($this, $key, $item));
        $this->setCount($this->count() + 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveCustom(CollectionInterface $collection, $key, $value=null, ...$params)
    {
        $resolvers = [];

        /**
         * @var CustomResolverCollectionInterface $resolver
         */
        foreach($this as $resolver){
            $key = $resolver->resolveCustom($collection, $key, $value, ...$params);
            $resolvers[] = get_class($resolver);
        }

        try{

            ArrayHelper::validateKey($key);

        }catch(InvalidKeyException $e){

            $msg = sprintf(
                'Failed to resolve: %s to a valid key, tried the following resolvers: %s',
                var_export($key, true),
                implode(',', $resolvers)
            );

            throw new InvalidKeyException($msg, $e->getCode(), $e);
        }

        return $key;
    }
}