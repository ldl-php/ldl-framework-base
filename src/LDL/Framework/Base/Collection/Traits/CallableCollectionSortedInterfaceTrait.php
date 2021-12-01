<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Collection\Contracts\SortByKeyInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Traits\SortByKeyInterfaceTrait;
use LDL\Framework\Base\Collection\Traits\CollectionInterfaceTrait;
use LDL\Framework\Base\Collection\Contracts\CallableCollectionSortedInterface;

/**
 * Trait CallableCollectionSortedInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see CallableCollectionSortedInterface
 */
trait CallableCollectionSortedInterfaceTrait
{
    /**
     * executes the callables in CallableCollection in specific order
     *
     * @param string $sort
     * @param array $params
     * @return void
     */
    public function callSorted(string $sort = Constants::SORT_ASCENDING, ...$params): void
    {
        $this->requireTraits([CollectionInterfaceTrait::class, SortByKeyInterfaceTrait::class]);
        $this->requireImplements([CollectionInterface::class]);

        $sortedCallableCollection = $this->ksort($sort);

        foreach($sortedCallableCollection as $closure){
            $closure(...$params);
        }
    }
}