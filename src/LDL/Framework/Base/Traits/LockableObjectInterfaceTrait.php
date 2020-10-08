<?php declare(strict_types=1);

/**
 * Trait which implements LockableObjectInterface
 * @see \LDL\Framework\Base\Contracts\LockableObjectInterface
 */

namespace LDL\Framework\Base\Traits;

use LDL\Framework\Base\Exception\LockingException;

trait LockableObjectInterfaceTrait
{
    /**
     * This is intentionally left uninitialized to force initialization when this trait is used in a class
     * @var bool
     */
    private $_tLocked;

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