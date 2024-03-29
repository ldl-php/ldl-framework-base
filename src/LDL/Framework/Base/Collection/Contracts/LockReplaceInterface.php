<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\LockReplaceException;

interface LockReplaceInterface
{
    /**
     * Instead of doing if($this->isLockAppend()) { throw new LockReplaceException(...); } in every call
     * just use this method for simplicity.
     *
     * @throws LockReplaceException
     */
    public function checkLockReplace() : void;

    /**
     * @return CollectionInterface
     */
    public function lockReplace(): CollectionInterface;

    /**
     * @return bool
     */
    public function isLockReplace() : bool;
}