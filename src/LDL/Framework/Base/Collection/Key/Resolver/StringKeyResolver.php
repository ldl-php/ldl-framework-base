<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\KeyResolverInterface;

class StringKeyResolver implements KeyResolverInterface
{

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var int
     */
    private $limit;

    public function __construct(string $prefix='_', int $limit=100000)
    {
        $this->prefix = $prefix;
        $this->limit = $limit;
    }

    public function resolve(CollectionInterface $collection, $key, $value=null)
    {
        if(!is_string($key)) {
            return $key;
        }

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