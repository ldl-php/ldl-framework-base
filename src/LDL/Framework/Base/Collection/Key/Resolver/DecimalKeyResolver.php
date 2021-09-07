<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\FullKeyResolverInterface;

class DecimalKeyResolver implements FullKeyResolverInterface
{
    private const DEFAULT_LIMIT = 1000000;
    private const DEFAULT_INCREMENT = 0.1;

    /**
     * @var float
     */
    private $increment;

    /**
     * @var float
     */
    private $count;

    /**
     * @var float
     */
    private $limit;

    public function __construct(float $increment=null, float $limit = null)
    {
        $this->increment = $increment ?? self::DEFAULT_INCREMENT;
        $this->limit = $limit ?? self::DEFAULT_LIMIT;
    }

    public function resolveCustom(CollectionInterface $collection, $key, $value = null, ...$params)
    {
        if(count($collection) === 0){
            return '0.0';
        }

        $this->count += $this->increment;

        return (string) $this->count;
    }

    public function resolveNull(CollectionInterface $collection, $item, ...$params)
    {
        return $this->resolveCustom($collection, null, $item, ...$params);
    }

    public function resolveDuplicate(CollectionInterface $collection, $key, $value=null, ...$params)
    {
        $isFloat = (float) $key > 0;

        if(!$isFloat){
            return $key;
        }

        if(!$collection->hasKey((string) $key)){
            return (string) $key;
        }

        $newKey = (float)$key;

        do {
            $newKey += $this->increment;

            if($newKey > $this->limit){
                throw new \LogicException("Exceeded new key limit of {$this->limit}");
            }

        } while($collection->hasKey((string) $newKey));

        return (string)$newKey;
    }
}