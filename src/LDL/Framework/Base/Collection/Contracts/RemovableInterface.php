<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface RemovableInterface
{
    /**
     * @param $item
     * @param $key
     */
    public function onBeforeRemove($item, $key): void;

    /**
     * Syntax sugar for unset($collection[$key]); or $collection->offsetUnset($key);
     *
     * @param $key
     * @throws \Exception
     * @return CollectionInterface
     */
    public function remove($key) : CollectionInterface;

    /**
     * Remove last appended item
     *
     * @throws \Exception
     * @return CollectionInterface
     */
    public function removeLast() : CollectionInterface;

    /**
     * Removes elements from a collection by value comparison
     *
     * @param $value
     * @param bool $strict
     * @return int Amount of removed elements
     */
    public function removeByValue($value, bool $strict = true) : int;
}