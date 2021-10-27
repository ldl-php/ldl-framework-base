<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\CollectionException;
use LDL\Framework\Base\Contracts\Type\ToArrayInterface;
use LDL\Framework\Helper\ArrayHelper\ArrayHelper;
use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;

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
     * @param string $operator
     * @param string $order
     * @throws \Exception if the passed key is not a valid array key
     * @see ArrayHelper::validateKey()
     * @return int
     */
    public function hasKey($key, string $operator, string $order) : int;

    /**
     * Check if a value exists inside the collection, comparison should between the given value and the collection
     * items should be performed by using strict comparison by default
     *
     * @param mixed $value
     * @param string $operator
     * @param string $order
     *
     * @return int
     */
    public function hasValue($value, string $operator, string $order) : int;

    /**
     * Obtain an element in the collection
     *
     * @param string|int $key
     * @throws \Exception
     * @return mixed
     */
    public function get($key);

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
     * @return string|int
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
     * @return string|int
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
     * @param callable $func
     * @param bool $preserveKeys
     * @param int $mapped
     * @param callable $comparisonFunc
     *
     * @return CollectionInterface
     * @throws InvalidKeyException
     * @throws \LDL\Framework\Base\Exception\LockingException
     */
    public function map(
        callable $func,
        bool $preserveKeys,
        int &$mapped,
        callable $comparisonFunc
    ) : CollectionInterface;

    /**
     * Use array_filter on each item of the collection, returns a new collection instance
     *
     * @param callable $func
     * @param int $filtered
     * @return CollectionInterface
     */
    public function filter(callable $func, int &$filtered=0) : CollectionInterface;

    /**
     * @param string $separator
     * @param bool $considerToStringObjects
     * @return string
     */
    public function implode(string $separator, bool $considerToStringObjects=true) : string;

    /**
     * Returns an instance of the collection which contains no items.
     *
     * @param mixed ...$params
     * @return CollectionInterface
     */
    public function getEmptyInstance(...$params) : CollectionInterface;

    /**
     * Returns a new instance, sorted by value through an anonymous comparison function
     *
     * @param callable $fn
     * @return CollectionInterface
     */
    public function sort(callable $fn) : CollectionInterface;

    /**
     * Returns a new instance, sorted by keys through an anonymous comparison function
     *
     * @param callable $fn
     * @return CollectionInterface
     */
    public function ksort(callable $fn) : CollectionInterface;
}