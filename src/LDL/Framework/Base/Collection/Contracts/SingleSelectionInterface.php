<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Base\Exception\LockingException;

interface SingleSelectionInterface extends SelectionLockingInterface
{

    /**
     * Select an item in the collection
     *
     * @throws LockingException if selection is locked
     * @param string $key
     * @return SingleSelectionInterface
     */
    public function select($key) : SingleSelectionInterface;

    /**
     * Return the selected item, previously selected by the select method
     *
     * @throws CollectionException if the collection is empty
     */
    public function getSelectedItem();

    /**
     * Returns the selected key
     * @return number|string
     */
    public function getSelectedKey();

    /**
     * Informs if an item was selected
     *
     * @return bool
     */
    public function hasSelection() : bool;
}