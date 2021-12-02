<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\LockRemoveException;
interface LockRemoveInterface
{
    /**
     * Instead of doing if($this->isLockAppend()) { throw new LockRemoveException(...); } in every call
     * just use this method for simplicity.
     *
     * @throws LockRemoveException
     */
    public function checkLockRemove() : void;

    /**
     * @return CollectionInterface
     */
    public function lockRemove(): CollectionInterface;

    /**
     * @return bool
     */
    public function isRemoveLock() : bool;
}