<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Exception\LockingException;

interface SelectionInterface extends SelectionLockingInterface
{

    /**
     * Select an item in the collection
     *
     * @throws LockingException if selection is locked
     * @param string|int $key
     * @return SelectionInterface
     */
    public function select($key) : SelectionInterface;

    /**
     * @param iterable $keys
     * @return SelectionInterface
     * @throws LockingException
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