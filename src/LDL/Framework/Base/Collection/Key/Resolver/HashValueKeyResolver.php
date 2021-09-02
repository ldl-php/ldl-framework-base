<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\FullKeyResolverInterface;

class HashValueKeyResolver implements FullKeyResolverInterface
{
    private const DEFAULT_ALGORITHM = 'sha1';
    private const DEFAULT_LIMIT = 1000000;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $increment;

    /**
     * @var int
     */
    private $limit;

    /**
     * @var string
     */
    private $algorithm;

    public function __construct(
        string $algorithm=null,
        int $increment=1,
        int $limit = null
    )
    {
        $this->increment = $increment;
        $this->limit = $limit ?? self::DEFAULT_LIMIT;

        if(null === $algorithm){
            $this->algorithm = self::DEFAULT_ALGORITHM;
        }

        if(in_array($algorithm, hash_algos(), true)) {
            $this->algorithm = $algorithm;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Invalid hashing algorithm: %s',
                $algorithm
            )
        );
    }

    public function resolveCustomKey(CollectionInterface $collection, $key, $item = null, ...$params)
    {
        return hash($this->algorithm, serialize($item), false);
    }

    public function resolveNullKey(CollectionInterface $collection, $item, ...$params)
    {
        $this->resolveCustomKey($collection, null, $item);
    }

    public function resolveDuplicateKey(CollectionInterface $collection, $key, $value=null, ...$params)
    {
        $i = 0;

        while($i++ < $this->limit){
            $newHash = sprintf(
                '%s_%s',
                $this->resolveCustomKey($collection, $key, $value),
                $this->count += $this->increment
            );

            if(!$collection->hasKey($newHash)){
                return $newHash;
            }
        }

        throw new \LogicException("Exceeded new key limit of {$this->limit}");
    }
}