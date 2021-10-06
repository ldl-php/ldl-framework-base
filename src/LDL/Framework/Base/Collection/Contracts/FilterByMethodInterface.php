<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByMethodInterface
{
    /**
     * @param string $method
     * @return CollectionInterface
     */
    public function filterByMethod(string $method) : CollectionInterface;

    /**
     * @param iterable $methods
     * @return CollectionInterface
     */
    public function filterByMethods(iterable $methods) : CollectionInterface;
}