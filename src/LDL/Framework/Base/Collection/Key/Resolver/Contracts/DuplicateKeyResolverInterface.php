<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Contracts;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

interface DuplicateKeyResolverInterface
{

    /**
     * @param CollectionInterface $collection
     * @param string|int|float|null $key
     * @param mixed $item
     * @param mixed ..$params
     * @return string|int|float|null
     */
    public function resolveDuplicateKey(CollectionInterface $collection, $key, $item, ...$params);

}