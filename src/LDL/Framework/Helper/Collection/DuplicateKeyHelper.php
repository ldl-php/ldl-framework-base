<?php declare(strict_types=1);

namespace LDL\Framework\Helper\Collection;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Helper\IterableHelper;

final class DuplicateKeyHelper
{
    public static function getBiggestKey(CollectionInterface $collection)
    {
        $keys = $collection->keys();

        $keys = IterableHelper::filter($keys, static function($k){
            return is_int($k);
        });

        /**
         * No integer key was found it so 0 is the greater
         */
        if(count($keys) === 0){
            return 0;
        }

        usort($keys, function($a, $b){
            return $a > $b;
        });

        return $keys[count($keys)-1] + 1;
    }
}