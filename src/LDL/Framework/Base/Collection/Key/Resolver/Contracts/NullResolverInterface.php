<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Contracts;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

interface NullResolverInterface
{

    /**
     * @param CollectionInterface $collection
     * @param mixed $item
     * @param mixed ...$params
     * @return string|int|float|null
     */
    public function resolveNull(CollectionInterface $collection, $item, ...$params);

}