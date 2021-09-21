<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Exception\LockAppendException;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

/**
 * Trait LockAppendInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see LockAppendInterface
 */
trait LockAppendInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var bool
     */
    private $_tIsAppendLock = false;

    //<editor-fold desc="LockAppendInterface methods">
    public function checkLockAppend(): void
    {
        if(true === $this->isLockAppend()){
            $msg = 'Collection is locked, can not add elements';

            throw new LockAppendException($msg);
        }
    }

    public function lockAppend(): CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            LockAppendInterface::class
        ]);

        $this->_tIsAppendLock = true;

        return $this;
    }

    public function isLockAppend() : bool
    {
        $this->requireImplements([
            CollectionInterface::class,
            LockAppendInterface::class
        ]);

        return $this->_tIsAppendLock;
    }
    //</editor-fold>
}