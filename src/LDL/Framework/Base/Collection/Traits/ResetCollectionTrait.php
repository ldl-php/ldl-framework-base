<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */
namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

trait ResetCollectionTrait
{
    private function _reset() : CollectionInterface
    {
        /**
         * @var CollectionInterface $collection
         */
        $collection = clone $this;
        $collection->items = [];
        $collection->first = null;
        $collection->last = null;
        $collection->count = 0;

        return $collection;
    }
}