<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

interface SortInterface
{
    public const SORT_ASCENDING = 'asc';
    public const SORT_DESCENDING = 'desc';

    public function sort(string $order=self::SORT_ASCENDING) : int;
}