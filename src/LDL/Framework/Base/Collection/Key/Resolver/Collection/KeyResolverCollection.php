<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection;

use http\Exception\InvalidArgumentException;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\KeyResolverInterface;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Traits\AppendManyTrait;
use LDL\Framework\Base\Collection\Traits\BeforeAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\BeforeRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockAppendInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\LockRemoveInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\RemovableInterfaceTrait;
use LDL\Framework\Base\Traits\LockableObjectInterfaceTrait;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;

class KeyResolverCollection implements KeyResolverCollectionInterface
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

    public function append($item, $key = null): CollectionInterface
    {
        if(!$item instanceof KeyResolverInterface) {
            $msg = sprintf(
                'Given item is not an instance of "%s", "%s" was given',
                KeyResolverInterface::class,
                is_object($item) ? get_class($item) : gettype($item)
            );

            throw new \InvalidArgumentException($msg);
        }

        $this->setItem($item, (new IntegerKeyResolver())->resolve($this, $key, null));
        $this->setCount($this->count() + 1);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(CollectionInterface $collection, $key, $value=null, ...$params)
    {
        $resolvers = [];

        /**
         * @var KeyResolverInterface $resolver
         */
        foreach($this as $resolver){
            $key = $resolver->resolve($collection, $key, $value, ...$params);
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