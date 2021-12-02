<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\LockRemoveException;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\RemoveException;

interface RemoveByKeyInterface
{
    /**
     * Remove an element from a collection by a specific key.
     *
     * @param string|int $key
     * @param string $operator
     * @param string $order
     * @throws LockRemoveException
     * @throws InvalidKeyException
     *
     * @return int Returns 0 if no elements have been removed, > 0 when elements have been removed
     */
    public function removeByKey($key, string $operator, string $order) : int;

    /**
     * Remove last appended item
     *
     * @throws LockRemoveException
     * @throws RemoveException
     * @return CollectionInterface
     */
    public function removeLast() : CollectionInterface;

}