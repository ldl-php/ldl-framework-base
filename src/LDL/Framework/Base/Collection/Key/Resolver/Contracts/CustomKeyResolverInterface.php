<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Contracts;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

/**
 * Interface CustomKeyResolverInterface
 * @package LDL\Framework\Base\Collection\Key\Resolver\Contracts
 */

interface CustomKeyResolverInterface
{

    /**
     * @param CollectionInterface $collection
     * @param mixed $key
     * @param mixed $item
     * @param mixed ...$params
     * @return string|int
     */
    public function resolveCustomKey(CollectionInterface $collection, $key, $item=null, ...$params);

}