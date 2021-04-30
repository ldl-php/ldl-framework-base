<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockReplaceInterface;
use LDL\Framework\Base\Collection\Exception\LockReplaceException;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait LockReplaceInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var bool
     */
    private $_tIsReplaceLock = false;

    //<editor-fold desc="LockReplaceInterface methods">
    public function checkLockReplace(): void
    {
        if(true === $this->isLockReplace()){
            $msg = 'Collection is locked, can not replace elements';

            throw new LockReplaceException($msg);
        }
    }

    public function lockReplace(): CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            LockReplaceInterface::class
        ]);

        $this->_tIsReplaceLock = true;

        return $this;
    }

    public function isLockReplace() : bool
    {
        $this->requireImplements([
            CollectionInterface::class,
            LockReplaceInterface::class
        ]);

        return $this->_tIsReplaceLock;
    }
    //</editor-fold>
}