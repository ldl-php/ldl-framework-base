<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\KeyResolverInterface;
use LDL\Framework\Helper\IterableHelper;

class IntegerKeyResolver implements KeyResolverInterface
{
    public function resolve(CollectionInterface $collection, $key, $value=null)
    {
        $isInteger = is_int($key);

        if(!$isInteger){
            return $key;
        }

        if($isInteger && !$collection->hasKey($key)){
            return $key;
        }

        $keys = $collection->keys();

        /**
         * No integer key was found it so 0 is the greater
         */
        if(count($keys) === 0){
            return 0;
        }

        $keys = IterableHelper::filter($keys, static function($k){
            return is_int($k);
        });

        usort($keys, static function($a, $b){
            return $a > $b;
        });

        return $keys[count($keys)-1] + 1;
    }
}