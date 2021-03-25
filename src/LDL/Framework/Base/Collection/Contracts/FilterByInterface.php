<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface FilterByInterface
{
    /**
     * @param string $interface
     *
     * @throws \InvalidArgumentException
     *
     * @return CollectionInterface
     */
    public function filterByInterface(string $interface) : CollectionInterface;
}