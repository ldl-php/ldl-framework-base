<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Contracts\IsActiveInterface;

interface FilterByActiveStateInterface
{
    /**
     * Filters a collection by items which are active
     *
     * @see IsActiveInterface
     *
     * @return CollectionInterface
     */
    public function filterByActiveState() : CollectionInterface;
}