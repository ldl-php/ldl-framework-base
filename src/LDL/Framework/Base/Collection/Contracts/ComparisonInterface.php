<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface ComparisonInterface
{
    /**
     * This is useful when you need to get comparison values from an object
     * for example to filter unique values
     *
     * @return int|string|double|bool|null
     */
    public function getComparisonValue();
}