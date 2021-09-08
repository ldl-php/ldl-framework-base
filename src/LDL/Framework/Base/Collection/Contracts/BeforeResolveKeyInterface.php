<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;

interface BeforeResolveKeyInterface
{
    /**
     * Returns a collection which holds callbacks, said callbacks must be executed before
     * resolving the collection key, and before adding a new element to the collection.
     *
     * The call to this collection of callables must be done BY REFERENCE, so a chance to modify
     * anything before appending is provided.
     *
     * @return CallableCollectionInterface
     */
    public function getBeforeResolveKey() : CallableCollectionInterface;
}

