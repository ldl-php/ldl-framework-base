<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Contracts;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

/**
 * Interface CustomKeyResolverInterface
 * @package LDL\Framework\Base\Collection\Resolver\Contracts
 */

interface CustomResolverInterface
{

    /**
     * @param CollectionInterface $collection
     * @param mixed $key
     * @param mixed $item
     * @param mixed ...$params
     * @return string|int
     */
    public function resolveCustom(CollectionInterface $collection, $key, $item=null, ...$params);

}