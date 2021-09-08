<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Key;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Resolver\Contracts\FullResolverInterface;

class RandomKeyResolver implements FullResolverInterface
{
    private const DEFAULT_LIMIT = 1000000;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var int
     */
    private $limit;

    public function __construct(string $prefix='rnd_', int $limit=null)
    {
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
        $this->prefix = $prefix;
    }

    public function resolveCustom(CollectionInterface $collection, $key, $item = null, ...$params)
    {
        return uniqid($this->prefix,true);
    }

    public function resolveNull(CollectionInterface $collection, $item=null, ...$params)
    {
        return $this->resolveCustom($collection, null, ...$params);
    }

    public function resolveDuplicate(CollectionInterface $collection, $key, $item=null, ...$params)
    {
        $i = 0;

        while($i++ < $this->limit){
            $newKey = $this->resolveNull($collection,$item);
            if(!$collection->hasKey($newKey)){
                return $newKey;
            }
        }

        throw new \LogicException("Could not resolve a suitable key for $key");
    }
}