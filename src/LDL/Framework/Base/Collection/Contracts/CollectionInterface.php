<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Base\Contracts\ToArrayInterface;

interface CollectionInterface extends \Countable, \Iterator, ToArrayInterface
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
}