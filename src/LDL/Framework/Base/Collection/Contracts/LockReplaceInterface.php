<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface LockReplaceInterface
{
    /**
     * @return CollectionInterface
     */
    public function lockReplace(): CollectionInterface;

    /**
     * @return bool
     */
    public function isReplaceLock() : bool;
}