<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Base\Exception\InvalidArgumentException;
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
     * @param string $order
     * @return CollectionInterface
     */
    public function ksort(string $sort = Constants::SORT_ASCENDING, string $order = Constants::COMPARE_LTR): CollectionInterface
    {
        $fn = static function ($a, $b) use ($sort, $order) {
            if (ComparisonOperatorHelper::compare($a, $b, Constants::OPERATOR_EQ))
                return 0;

            $comparison = ComparisonOperatorHelper::compare($a, $b, Constants::OPERATOR_GT, $order);

            if ($sort == Constants::SORT_ASCENDING) {
                return $comparison ? 1 : -1;
            }

            if ($sort == Constants::SORT_DESCENDING) {
                return $comparison ? -1 : 1;
            }
        };

        return $this->keySortByCallback($fn);
    }

    /**
     * Returns a new instance, sorted by key through an anonymous comparison function
     *
     * @param callable $fn
     * @return CollectionInterface
     */
    public function keySortByCallback(callable $fn): CollectionInterface
    {
        $items = $this->items;

        if ($this->_isLocked()) {
            $items = \iterator_to_array($this, true);
        }

        uksort($items, $fn);
        $instance = $this->getEmptyInstance();
        $instance->items = $items;
        return $instance;
    }
}
