<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByValueTypeInterface
{
    /**
     * Filters a mixed collection by type value
     *
     * @see \gettype
     * @param string $value
     * @return CollectionInterface
     */
    public function filterByValueType(string $value) : CollectionInterface;

    /**
     * Filters a mixed collection against several PHP types
     *
     * @see \gettype
     * @param iterable $types
     * @return CollectionInterface
     */
    public function filterByValueTypes(iterable $types): CollectionInterface;

}