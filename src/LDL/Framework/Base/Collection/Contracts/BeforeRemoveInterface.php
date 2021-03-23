<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;

interface BeforeRemoveInterface
{
    /**
     * Returns a collection which holds callbacks, said callbacks must be executed before
     * removing an element of the collection.
     *
     * @return CallableCollectionInterface
     */
    public function getBeforeRemove() : CallableCollectionInterface;
}

