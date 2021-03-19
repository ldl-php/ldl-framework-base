<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface LockAppendInterface
{
    /**
     * @return CollectionInterface
     */
    public function lockAppend(): CollectionInterface;

    /**
     * @return bool
     */
    public function isAppendLock() : bool;
}