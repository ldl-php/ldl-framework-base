<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Exception\LockingException;

interface SelectionLockingInterface
{

    /**
     * Locks selection, avoid further elements to be selected in this collection
     *
     * @throws LockingException if the selection was already locked
     * @return SelectionLockingInterface
     */
    public function lockSelection() : SelectionLockingInterface;

    /**
     * Tells the user if item selection is locked or not
     *
     * @see self::select (second parameter $lockSelected)
     * @return bool
     */
    public function isSelectionLocked() : bool;

}