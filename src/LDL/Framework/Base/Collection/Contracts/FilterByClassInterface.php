<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByClassInterface
{
    /**
     * @param string $class
     *
     * @throws \InvalidArgumentException
     *
     * @return CollectionInterface
     */
    public function filterByClass(string $class) : CollectionInterface;
}