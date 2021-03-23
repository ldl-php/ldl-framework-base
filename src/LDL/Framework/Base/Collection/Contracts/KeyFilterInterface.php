<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\CollectionException;

interface KeyFilterInterface
{
    /**
     * @param string $key
     *
     * @throws CollectionException
     *
     * @return mixed
     */
    public function filterByKey(string $key);

    /**
     * @param iterable $keys
     * @return CollectionInterface
     */
    public function filterByKeys(iterable $keys) : CollectionInterface;

    /**
     * @param string $regex
     * @return CollectionInterface
     */
    public function filterByKeyRegex(string $regex) : CollectionInterface;
}