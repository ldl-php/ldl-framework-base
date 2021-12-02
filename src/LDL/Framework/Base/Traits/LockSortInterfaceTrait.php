<?php declare(strict_types=1);

namespace LDL\Framework\Base\Traits;

use LDL\Framework\Base\Exception\LockingException;

/**
 * Trait which implements LockSortInterfaceTrait
 * @see \LDL\Framework\Base\Contracts\LockSortInterface
 */
trait LockSortInterfaceTrait
{
    private $_tSortLocked = false;

    /**
     * Let's the user know if the the object is sort locked or not
     * 
     * @return bool
     */
    public function isSortLocked(): bool
    {
        return $this->_tSortLocked;
    }

    /**
     * Locks an object to prevent sort
     *
     * @throws LockingException if the object is already locked
     * 
     * @return mixed
     */
    public function lockSort()
    {
        if(true === $this->_tSortLocked){
            $msg = sprintf(
                'Object of class: "%s" has already been locked',
                __CLASS__
            );

            throw new LockingException($msg);
        }

        $this->_tSortLocked = true;
        return $this;
    }
}