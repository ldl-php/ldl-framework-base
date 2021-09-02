<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\Contracts\KeyResolverInterface;

class RandomKeyResolver implements KeyResolverInterface
{

    public function resolve(CollectionInterface $collection, $key, $value=null)
    {
        do {
            $newKey = uniqid('rnd_',true);

        } while($collection->hasKey($newKey));

        return $newKey;
    }
}