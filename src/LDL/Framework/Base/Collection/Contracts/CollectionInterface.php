<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Base\Contracts\ToArrayInterface;

interface CollectionInterface extends \ArrayAccess, \Countable, \Iterator, ToArrayInterface
{
    /**
     * Return associated indices
     *
     * @return array
     */
    public function keys() : array;

    /**
     * Check if a key exists
     *
     * @param number|string $key
     * @return bool
     */
    public function hasKey($key) : bool;

    /**
     * Check if a value exists inside the collection, comparison should between the given value and the collection
     * items should be performed by using strict comparison
     *
     * @param $value
     * @return bool
     */
    public function hasValue($value) : bool;

    /**
     * Obtains the first element in the collection
     *
     * @throws CollectionException if there are no elements inside the collection
     * @return mixed
     */
    public function getFirst();

    /**
     * Returns the first appended key
     *
     * @return string|number
     */
    public function getFirstKey();

    /**
     * Obtains the last element in the collection
     *
     * @throws CollectionException if there are no elements inside the collection
     * @return mixed
     */
    public function getLast();

    /**
     * Returns the last appended key
     *
     * @return string|number
     */
    public function getLastKey();

    /**
     * Syntactic sugar to determine if the collection is empty or not (since you could use $collection->count() === 0)
     * @return bool
     */
    public function isEmpty() : bool;

    /**
     * Use a callable function on each item of the collection
     *
     * @param callable $callback
     * @return CollectionInterface
     */
    public function map(callable $callback) : CollectionInterface;

    /**
     * Use array_filter on each item of the collection, returns a new collection instance
     *
     * @param callable $callback
     * @param int $mode
     * @return CollectionInterface
     */
    public function filter(callable $callback, int $mode=0) : CollectionInterface;
}