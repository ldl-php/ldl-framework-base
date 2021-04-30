<?php declare(strict_types=1);

/**
 * This trait applies the SingleSelectionInterface so you can just easily use it in your class.
 * @see \LDL\Framework\Base\Collection\Contracts\SingleSelectionInterface
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\SelectionLockingInterface;
use LDL\Framework\Base\Collection\Contracts\SingleSelectionInterface;
use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Base\Exception\LockingException;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait SingleSelectionInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var number|string|null
     */
    private $_tSelectedKey;

    /**
     * @var bool
     */
    private $_tSelectionLocked = false;

    //<editor-fold desc="SingleSelectionInterface methods">
    public function select($key) : SingleSelectionInterface
    {
        $this->_validateLockedSelection();

        /**
         * @var CollectionInterface $_this
         */
        $_this = $this;

        if($this->_tSelectionLocked){
            $msg = 'Selection of items has been locked, can not select more items in this collection';
            throw new LockingException($msg);
        }

        if(!is_scalar($key)){
            throw new CollectionException('Selection key must be of scalar type');
        }

        /**
         * If offset does not exists, it will throw an UndefinedOffsetException
         */
        $this->get($key);

        $this->_tSelectedKey = $key;

        return $_this;
    }

    public function getSelectedItem()
    {
        $this->requireImplements([
            CollectionInterface::class,
            SingleSelectionInterface::class
        ]);

        return $this->get($this->_tSelectedKey);
    }

    public function getSelectedKey()
    {
        $this->requireImplements([
            CollectionInterface::class,
            SingleSelectionInterface::class
        ]);

        return $this->_tSelectedKey;
    }

    public function hasSelection() : bool
    {
        $this->requireImplements([
            CollectionInterface::class,
            SingleSelectionInterface::class
        ]);

        return $this->_tSelectedKey !== null;
    }

    private function _validateLockedSelection() : void
    {
        $this->requireImplements([
            CollectionInterface::class,
            SingleSelectionInterface::class
        ]);

        if(false === $this->_tSelectionLocked) {
            return;
        }

        $msg = 'Selection of items has been locked, can not select more items in this collection';
        throw new LockingException($msg);
    }

    public function lockSelection() : SelectionLockingInterface
    {
        $this->_validateLockedSelection();
        $this->_tSelectionLocked = true;

        return $this;
    }

    public function isSelectionLocked() : bool
    {
        $this->requireImplements([
            CollectionInterface::class,
            SingleSelectionInterface::class
        ]);

        return $this->_tSelectionLocked;
    }
    //</editor-fold>
}