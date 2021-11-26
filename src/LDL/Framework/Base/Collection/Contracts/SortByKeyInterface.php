<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
interface SortByKeyInterface
{
    /**
     * Returns a new collection instance, sorted by key
     *
     * @param string $order
     * @param bool $sortByKey
     * @return CollectionInterface
     */
    public function ksort(string $sort, string $order): CollectionInterface;

    /**
     * Returns a new instance, sorted by key through an anonymous comparison function
     *
     * @param callable $fn
     * @return CollectionInterface
     */
    public function keySortByCallback(callable $fn) : CollectionInterface;
}