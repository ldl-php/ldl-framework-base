<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\LockAppendException;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;

interface AppendableInterface
{
    /**
     * Append an element to the collection
     *
     * @param mixed $item
     * @param mixed $key
     *
     * @throws LockAppendException
     * @throws InvalidKeyException
     *
     * @return CollectionInterface
     */
    public function append($item, $key = null) : CollectionInterface;

    /**
     * Append many elements (same as append but for many elements)
     *
     * @param iterable $items
     * @param bool $useKey (use key when appending, false by default)
     *
     * @throws LockAppendException
     * @throws InvalidKeyException
     *
     * @return CollectionInterface
     */
    public function appendMany(iterable $items, bool $useKey=false) : CollectionInterface;
}