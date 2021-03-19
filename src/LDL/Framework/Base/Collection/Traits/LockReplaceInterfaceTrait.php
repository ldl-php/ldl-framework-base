<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Exception\LockReplaceException;

trait LockReplaceInterfaceTrait
{
    /**
     * @var bool
     */
    private $_tIsReplaceLock = false;

    public function checkLockReplace(): void
    {
        if(true === $this->isReplaceLock()){
            $msg = 'Collection is locked, can not replace elements';

            throw new LockReplaceException($msg);
        }
    }

    //<editor-fold desc="LockReplaceInterface methods">
    public function lockReplace(): CollectionInterface
    {
        $this->_tIsReplaceLock = true;
        return $this;
    }

    public function isReplaceLock() : bool
    {
        return $this->_tIsReplaceLock;
    }
    //</editor-fold>
}