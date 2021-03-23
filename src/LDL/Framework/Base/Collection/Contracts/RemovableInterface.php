<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Base\Collection\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Exception\LockingException;

interface RemovableInterface
{
    /**
     * Syntax sugar for unset($collection[$key]); or $collection->offsetUnset($key);
     *
     * @param $key
     *
     * @throws LockingException
     * @throws RemoveException
     * @throws InvalidKeyException
     *
     * @return CollectionInterface
     */
    public function remove($key) : CollectionInterface;

    /**
     * Remove last appended item
     *
     * @throws LockingException
     * @throws RemoveException
     * @return CollectionInterface
     */
    public function removeLast() : CollectionInterface;

    /**
     * Removes elements from a collection by value comparison
     *
     * @param $value
     * @param bool $strict
     * @throws LockingException
     * @throws RemoveException
     * @return int Amount of removed elements
     */
    public function removeByValue($value, bool $strict = true) : int;
}