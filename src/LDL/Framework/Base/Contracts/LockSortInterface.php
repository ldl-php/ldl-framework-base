<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

use LDL\Framework\Base\Collection\Exception\LockSortException;

interface LockSortInterface
{
    /**
     * Let's the user know if the the object is sort locked or not
     * 
     * @return bool
     */
    public function isSortLocked(): bool;

    /**
     * Locks an object to prevent sort
     *
     * @throws LockSortException if the object is already locked
     * 
     * @return mixed
     */
    public function lockSort();
}
