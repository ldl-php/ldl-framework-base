<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Exception\LockingException;

interface RemoveByKeyInterface
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
    public function removeByKey($key) : CollectionInterface;

    /**
     * Remove last appended item
     *
     * @throws LockingException
     * @throws RemoveException
     * @return CollectionInterface
     */
    public function removeLast() : CollectionInterface;

}