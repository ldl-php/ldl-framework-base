<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface LockRemoveInterface
{
    /**
     * @return CollectionInterface
     */
    public function lockRemove(): CollectionInterface;

    /**
     * @return bool
     */
    public function isRemoveLock() : bool;
}