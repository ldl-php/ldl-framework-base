<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByNameInterface
{
    /**
     * Filter a collection by name
     *
     * @param string $name
     *
     * @return CollectionInterface
     */
    public function filterByName(string $name) : CollectionInterface;

    /**
     * Filters a collection which has NameableInterface items through an array of names
     *
     * @param iterable $names
     * @return CollectionInterface
     */
    public function filterByNames(iterable $names) : CollectionInterface;

    /**
     * Filter the collection with a name regex
     *
     * @param string $regex
     * @return CollectionInterface
     */
    public function filterByNameRegex(string $regex) : CollectionInterface;

    /**
     * Auto determines the $mixed value and applies the appropriate filtering method to filter the collection,
     * use this to avoid multiple if's in your code.
     *
     * @param $mixed
     *
     * @return CollectionInterface
     */
    public function filterByNameAuto($mixed) : CollectionInterface;

}
