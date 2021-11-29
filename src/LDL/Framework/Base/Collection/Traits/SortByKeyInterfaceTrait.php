<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Exception\LockingException;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Base\Collection\Contracts\SortByKeyInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

/**
 * Trait SortByKeyInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see SortByKeyInterface
 */
trait SortByKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * Returns a new collection instance, sorted by key.
     *
     * @param string $sort
     * @param string $order
     * @return CollectionInterface
     * @throws \LDL\Framework\Base\Exception\RuntimeException
     */
    public function ksort(string $sort = Constants::SORT_ASCENDING, string $order = Constants::COMPARE_LTR): CollectionInterface
    {
        $fn = static function ($a, $b) use ($sort, $order) {
            if (ComparisonOperatorHelper::compare($a, $b, Constants::OPERATOR_EQ)) {
                return 0;
            }

            $comparison = ComparisonOperatorHelper::compare($a, $b, Constants::OPERATOR_GT, $order);

            if (Constants::SORT_ASCENDING === $sort) {
                return $comparison ? 1 : -1;
            }

            if (Constants::SORT_DESCENDING === $sort) {
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
     * @throws \LDL\Framework\Base\Exception\RuntimeException
     * @throws LockingException
     */
    public function keySortByCallback(callable $fn): CollectionInterface
    {
        if($this instanceof LockableObjectInterface && $this->isLocked()){
            throw new LockingException('Can not sort collection by key, collection is locked!');
        }

        $this->requireTraits([CollectionInterfaceTrait::class]);
        $this->requireImplements([SortByKeyInterface::class]);
        $items = $this->toArray(true);
        uksort($items, $fn);
        $this->setItems($items);

        return $this;
    }
}
