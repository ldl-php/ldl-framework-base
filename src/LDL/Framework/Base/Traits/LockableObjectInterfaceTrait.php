<?php declare(strict_types=1);

/**
 * Trait which implements LockableObjectInterface
 * @see \LDL\Framework\Base\Contracts\LockableObjectInterface
 */

namespace LDL\Framework\Base\Traits;

use LDL\Framework\Base\Exception\LockingException;

trait LockableObjectInterfaceTrait
{
    private $_tLocked = false;

    public function isLocked(): bool
    {
        return $this->_tLocked;
    }

    public function lock()
    {
        if(true === $this->_tLocked){
            $msg = sprintf(
                'Object of class: "%s" has already been locked',
                __CLASS__
            );

            throw new LockingException($msg);
        }

        $this->_tLocked = true;
        return $this;
    }
}