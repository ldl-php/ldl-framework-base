<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\SortHelper;
use LDL\Framework\Base\Exception\LockingException;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Collection\Contracts\SortInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
/**
 * Trait SortInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see SortInterface
 */
trait SortInterfaceTrait
{
    /**
     * Returns a new collection instance, sorted by value.
     *
     * @param string $sort
     * @return CollectionInterface
     */
    public function sort(string $sort = Constants::SORT_ASCENDING): CollectionInterface
    {
        $items = SortHelper::sort($sort, iterator_to_array($this));
        
        $this->setItems($items);

        return $this;
    }

    /**
     * Returns a new instance, sorted by value through an anonymous comparison function
     *
     * @param callable $fn
     * @return CollectionInterface
     */
    public function sortByCallback(callable $fn): CollectionInterface
    {
        if($this instanceof LockableObjectInterface && $this->isLocked()){
            throw new LockingException('Can not sort collection by value, collection is locked!');
        }

        $this->requireTraits([CollectionInterfaceTrait::class]);
        $this->requireImplements([SortInterface::class]);
        
        $items = SortHelper::sortByCallback($fn, $this->toArray(true));
        $this->setItems($items);

        return $this;
    }
}
