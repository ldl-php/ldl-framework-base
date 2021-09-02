<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;

interface BeforeResolveKeyInterface
{
    /**
     * Returns a collection which holds callbacks, said callbacks must be executed before
     * adding a new element to the collection.
     *
     * @return CallableCollectionInterface
     */
    public function getBeforeResolveKey() : CallableCollectionInterface;
}

