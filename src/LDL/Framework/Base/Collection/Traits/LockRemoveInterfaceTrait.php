<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Exception\LockRemoveException;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

/**
 * Trait LockRemoveInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see LockRemoveInterface
 */
trait LockRemoveInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var bool
     */
    private $_tIsRemoveLock = false;

    //<editor-fold desc="LockRemoveInterface methods">
    public function checkLockRemove(): void
    {
        if(true === $this->isRemoveLock()){
            $msg = 'Collection is locked, can not remove elements';

            throw new LockRemoveException($msg);
        }
    }

    public function lockRemove(): CollectionInterface
    {
        $this->requireImplements([
            CollectionInterface::class,
            LockRemoveInterface::class
        ]);

        $this->_tIsRemoveLock = true;

        return $this;
    }

    public function isRemoveLock() : bool
    {
        $this->requireImplements([
            CollectionInterface::class,
            LockRemoveInterface::class
        ]);

        return $this->_tIsRemoveLock;
    }
    //</editor-fold>
}