<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Exception\LockingException;

interface LockableObjectInterface{
    /**
     * Instead of doing if($this->isLocked()) { throw new LockingException(...); } in every call
     * just use this method for simplicity.
     *
     * @throws LockingException
     */
    public function checkLock() : void;

    /**
     * Locks an object
     *
     * @throws LockingException if the object is already locked
     * @return mixed
     */
    public function lock();

    /**
     * Let's the user know if the the object is locked or not
     * @return bool
     */
    public function isLocked(): bool;
}