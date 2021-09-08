<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;

interface HasValueResolverInterface
{
    /**
     * Returns a collection which holds callbacks, said callbacks must be executed before
     * adding a new element to the collection.
     *
     * @return CallableCollectionInterface
     */
    public function getValueResolver() : CallableCollectionInterface;
}

