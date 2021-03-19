<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Exception\LockRemoveException;

trait LockRemoveInterfaceTrait
{
    /**
     * @var bool
     */
    private $_tIsRemoveLock = false;

    public function checkLockRemove(): void
    {
        if(true === $this->isRemoveLock()){
            $msg = 'Collection is locked, can not remove elements';

            throw new LockRemoveException($msg);
        }
    }

    //<editor-fold desc="LockRemoveInterface methods">
    public function lockRemove(): CollectionInterface
    {
        $this->_tIsRemoveLock = true;
        return $this;
    }

    public function isRemoveLock() : bool
    {
        return $this->_tIsRemoveLock;
    }
    //</editor-fold>
}