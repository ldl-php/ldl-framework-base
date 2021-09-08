<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\FullKeyResolverInterface;
use LDL\Framework\Helper\IterableHelper;

class IntegerKeyResolver implements FullKeyResolverInterface
{
    /**
     * @var int
     */
    private $increment;

    /**
     * @var int
     */
    private $count;

    public function __construct(int $increment=1)
    {
        $this->count = 0;
        $this->increment = $increment;
    }

    public function resolveCustomKey(CollectionInterface $collection, $key, $item = null, ...$params)
    {
        if(count($collection)===0){
            return 0;
        }

        $this->count += $this->increment;
        return $this->count;
    }

    public function resolveNullKey(CollectionInterface $collection, $item, ...$params)
    {
        return $this->resolveCustomKey($collection, null, $item, ...$params);
    }

    public function resolveDuplicateKey(CollectionInterface $collection, $key, $item=null, ...$params)
    {
        if(!is_int($key)){
            return $key;
        }

        $keys = $collection->keys();

        $keys = IterableHelper::filter($keys, static function($k){
            return is_int($k);
        });

        usort($keys, static function($a, $b){
            return $a > $b;
        });

        return $keys[count($keys)-1] + 1;
    }
}