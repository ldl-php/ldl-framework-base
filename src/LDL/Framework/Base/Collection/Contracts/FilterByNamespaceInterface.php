<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByNamespaceInterface extends FilterByNameInterface
{
    /**
     * Filter a collection by namespace
     *
     * @param string $namespace
     *
     * @return CollectionInterface
     */
    public function filterByNamespace(string $namespace) : CollectionInterface;

    /**
     * Filter a collection by multiple namespaces
     *
     * @param iterable $namespaces
     * @return CollectionInterface
     */
    public function filterByNamespaces(iterable $namespaces) : CollectionInterface;

    /**
     * Filter the collection with a namespace regex
     *
     * @param string $regex
     * @return CollectionInterface
     */
    public function filterByNamespaceRegex(string $regex) : CollectionInterface;

    /**
     * Filter a collection with elements that match a given namespace and name combination
     *
     * @param string $namespace
     * @param string $name
     * @return CollectionInterface
     */
    public function filterByNamespaceAndName(
        string $namespace,
        string $name
    ) : CollectionInterface;

    /**
     * Auto determines the $mixed value and applies the appropriate filtering method to filter the collection,
     * use this to avoid multiple if's in your code.
     *
     * @param $mixed
     *
     * @return CollectionInterface
     */
    public function filterByNamespaceAuto($mixed) : CollectionInterface;
}
