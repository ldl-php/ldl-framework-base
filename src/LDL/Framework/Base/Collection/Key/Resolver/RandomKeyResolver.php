<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\FullKeyResolverInterface;

class RandomKeyResolver implements FullKeyResolverInterface
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

    /**
     * @var int
     */
    private $count;

    public function __construct(string $prefix='rnd_', int $limit=null)
    {
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
        $this->prefix = $prefix;
        $this->count = 0;
    }

    public function resolveCustomKey(CollectionInterface $collection, $key, $value = null)
    {
        return uniqid($this->prefix,true);
    }

    public function resolveNullKey(CollectionInterface $collection, ...$params)
    {
        return $this->resolveCustomKey($collection, null, ...$params);
    }

    public function resolveDuplicateKey(CollectionInterface $collection, $key, $value=null)
    {
        $i = 0;

        while($i++ < $this->limit){
            $newKey = $this->resolveNullKey($collection,$value);
            if(!$collection->hasKey($newKey)){
                return $newKey;
            }
        }

        throw new \LogicException("Could not resolve a suitable key for $key");
    }
}