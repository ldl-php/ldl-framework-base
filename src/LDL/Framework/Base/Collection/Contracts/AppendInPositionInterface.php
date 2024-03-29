<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Exception\InvalidArgumentException;
use LDL\Framework\Base\Collection\Exception\LockAppendException;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;

interface AppendInPositionInterface
{
    public const APPEND_POSITION_FIRST = 1;
    public const APPEND_POSITION_LAST = -1;

    /**
     * @param int $position
     * @throws InvalidArgumentException if the $position argument is invalid
     * @return bool
     */
    public function hasPosition(int $position) : bool;

    /**
     * Appends an element to the collection with a specific order
     *
     * @param mixed $item
     * @param int $position
     * @param string|int $key
     *
     * @throws InvalidArgumentException if the $position argument is invalid
     * @throws LockAppendException
     * @throws InvalidKeyException
     *
     * @return CollectionInterface
     */
    public function appendInPosition($item, int $position, $key = null): CollectionInterface;

    /**
     * Appends a set of elements in position N
     *
     * @param iterable $items
     * @param int $position
     *
     * @throws InvalidArgumentException if the $position argument is invalid
     * @throws LockAppendException
     * @throws InvalidKeyException
     *
     * @return CollectionInterface
     */
    public function appendManyInPosition(iterable $items, int $position) : CollectionInterface;

    /**
     * Alias of self::appendInPosition with APPEND_POSITION_FIRST as the $position argument
     * @param $item
     * @param $key
     * @return CollectionInterface
     */
    public function unshift($item, $key) : CollectionInterface;

    /**
     * @param iterable $items
     * @return CollectionInterface
     */
    public function unshiftMany(iterable $items) : CollectionInterface;
}