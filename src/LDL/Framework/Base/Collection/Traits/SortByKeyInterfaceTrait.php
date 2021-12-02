<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\SortHelper;
use LDL\Framework\Base\Exception\LockingException;
use LDL\Framework\Base\Contracts\LockSortInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Collection\Contracts\SortByKeyInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

/**
 * Trait SortByKeyInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see SortByKeyInterface
 */
trait SortByKeyInterfaceTrait
{
    /**
     * Returns a new collection instance, sorted by key.
     *
     * @param string $sort
     * @return CollectionInterface
     */
    public function ksort(string $sort = Constants::SORT_ASCENDING): CollectionInterface
    {
        if($this instanceof LockableObjectInterface && $this->isLocked()){
            throw new LockingException('Cannot sort collection by value, collection is locked!');
        }

        if($this instanceof LockSortInterface && $this->isSortLocked()){
            throw new LockingException('Collection is locked, cannot sort!');
        }
        
        $items = SortHelper::ksort($sort, iterator_to_array($this, true));

        $this->setItems($items);

        return $this;
    }

    /**
     * Returns a new instance, sorted by key through an anonymous comparison function
     *
     * @param callable $fn
     * @return CollectionInterface
     */
    public function keySortByCallback(callable $fn): CollectionInterface
    {
        if($this instanceof LockableObjectInterface && $this->isLocked()){
            throw new LockingException('Cannot sort collection by value, collection is locked!');
        }

        if($this instanceof LockSortInterface && $this->isSortLocked()){
            throw new LockingException('Collection is locked, cannot sort!');
        }

        $this->requireTraits([CollectionInterfaceTrait::class]);
        $this->requireImplements([SortInterface::class]);

        $items = SortHelper::keySortByCallback($fn, iterator_to_array($this, true));
        $this->setItems($items);

        return $this;
    }
}