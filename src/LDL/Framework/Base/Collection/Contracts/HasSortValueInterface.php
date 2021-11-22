<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface HasSortValueInterface
{
    /**
     * Returns the value to be sorted
     *
     * @return string
     */
    public function getSortValue();
}