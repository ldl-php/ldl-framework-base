<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\LockAppendException;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;

interface SelectionInterface extends SelectionLockingInterface
{

    /**
     * Select an item in the collection
     *
     * @throws LockAppendException
     * @throws InvalidKeyException
     * @throws LockSelectionException if selection is locked
     * @param string|int $key
     * @return SelectionInterface
     */
    public function select($key) : SelectionInterface;

    /**
     * @param iterable $keys
     * @return SelectionInterface
     * @throws LockAppendException
     * @throws InvalidKeyException
     * @throws LockSelectionException if selection is locked
     */
    public function selectMany(iterable $keys) : SelectionInterface;

    /**
     * @return CollectionInterface
     */
    public function getSelectedItems() : CollectionInterface;

    /**
     * @return array
     */
    public function getSelectedValues() : array;

    /**
     * Informs if an item was selected
     *
     * @return bool
     */
    public function hasSelection() : bool;
}