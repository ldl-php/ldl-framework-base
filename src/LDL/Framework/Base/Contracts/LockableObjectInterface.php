<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Exception\LockingException;

interface LockableObjectInterface{
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