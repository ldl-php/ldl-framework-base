<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Contracts;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

interface DuplicateResolverInterface
{

    /**
     * @param CollectionInterface $collection
     * @param string|int|float|null $key
     * @param mixed $item
     * @param mixed ..$params
     * @return string|int|float|null
     */
    public function resolveDuplicate(CollectionInterface $collection, $key, $item, ...$params);

}