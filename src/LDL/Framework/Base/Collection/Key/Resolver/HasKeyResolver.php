<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\FullKeyResolverInterface;
use LDL\Framework\Base\Contracts\HasKeyInterface;

class HasKeyResolver implements FullKeyResolverInterface
{
    private const DEFAULT_LIMIT = 1000000;
    private const DEFAULT_PREFIX = ':';

    /**
     * @var int
     */
    private $limit;

    /**
     * @var string
     */
    private $prefix;

    public function __construct(int $limit=null, string $prefix=null)
    {
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
        $this->prefix = $prefix ?? self::DEFAULT_PREFIX;
    }

    public function resolveCustomKey(CollectionInterface $collection, $key, $item = null, ...$params)
    {
        if(!is_object($item)) {
            return $key;
        }

        if(!$item instanceof HasKeyInterface){
            return $key;
        }

        return $item->getObjectKey();
    }

    public function resolveNullKey(CollectionInterface $collection, $item=null, ...$params)
    {
        return $this->resolveCustomKey($collection, null, $item, ...$params);
    }

    public function resolveDuplicateKey(CollectionInterface $collection, $key, $item, ...$params)
    {
        if(!is_object($item)) {
            return $key;
        }

        if(!$item instanceof HasKeyInterface){
            return $key;
        }

        $key = $item->getObjectKey();

        if(!$collection->hasKey($key)){
            return $key;
        }

        $i = 0;

        while($i++ < $this->limit){
            $newKey = "$key{$this->prefix}$i";
            if(!$collection->hasKey($newKey)){
                return $newKey;
            }
        }

        throw new \LogicException("Could not resolve a suitable key for $key");
    }
}