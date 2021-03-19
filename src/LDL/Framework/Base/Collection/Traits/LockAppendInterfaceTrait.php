<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Exception\LockAppendException;

trait LockAppendInterfaceTrait
{
    /**
     * @var bool
     */
    private $_tIsAppendLock = false;

    public function checkLockAppend(): void
    {
        if(true === $this->isAppendLock()){
            $msg = 'Collection is locked, can not add elements';

            throw new LockAppendException($msg);
        }
    }

    //<editor-fold desc="LockAppendInterface methods">
    public function lockAppend(): CollectionInterface
    {
        $this->_tIsAppendLock = true;
        return $this;
    }

    public function isAppendLock() : bool
    {
        return $this->_tIsAppendLock;
    }
    //</editor-fold>
}