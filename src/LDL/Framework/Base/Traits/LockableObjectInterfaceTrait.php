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

    //<editor-fold desc="LockableObjectInterface Methods">
    public function checkLock() : void
    {
        if($this->isLocked()){
            $msg = sprintf('Class %s is locked and may not be modified', __CLASS__);
            throw new LockingException($msg);
        }
    }

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
    //</editor-fold>
}