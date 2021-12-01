<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface CallableCollectionSortedInterface
{
    /**
     * executes the callables in CallableCollection in specific order
     *
     * @param string $sort
     * @param array $params
     * @return void
     */
    public function callSorted(string $sort, ...$params) : void;
}

