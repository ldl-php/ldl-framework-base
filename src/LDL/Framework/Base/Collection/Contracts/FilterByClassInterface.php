<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByClassInterface
{
    /**
     * @param string $class
     * @throws \InvalidArgumentException
     * @return CollectionInterface
     */
    public function filterByClass(string $class) : CollectionInterface;

    /**
     * If $strict is true
     * @param iterable $classes
     * @param bool $strict
     * @return CollectionInterface
     * @throws \InvalidArgumentException
     */
    public function filterByClasses(iterable $classes, bool $strict=true) : CollectionInterface;

    /**
     * @param string $className
     * @return CollectionInterface
     */
    public function filterByClassRecursive(string $className) : CollectionInterface;

    /**
     * @param iterable $classes
     * @return CollectionInterface
     */
    public function filterByClassesRecursive(iterable $classes) : CollectionInterface;
}