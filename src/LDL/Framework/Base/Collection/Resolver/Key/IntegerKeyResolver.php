<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Key;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Resolver\Contracts\FullResolverInterface;
use LDL\Framework\Helper\IterableHelper;

class IntegerKeyResolver implements FullResolverInterface
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

    public function resolveCustom(CollectionInterface $collection, $key, $item = null, ...$params)
    {
        if(count($collection)===0){
            return 0;
        }

        $this->count += $this->increment;
        return $this->count;
    }

    public function resolveNull(CollectionInterface $collection, $item, ...$params)
    {
        return $this->resolveCustom($collection, null, $item, ...$params);
    }

    public function resolveDuplicate(CollectionInterface $collection, $key, $item=null, ...$params)
    {
        $isInt = preg_match('#^\d+$#', (string) $key);

        if(!$isInt){
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