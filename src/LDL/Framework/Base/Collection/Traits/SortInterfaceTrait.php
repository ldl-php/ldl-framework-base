<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Contracts\LockableObjectInterface;
use LDL\Framework\Base\Exception\LockingException;
use LDL\Framework\Helper\ClassRequirementHelperTrait;
use LDL\Framework\Helper\ComparisonOperatorHelper;
use LDL\Framework\Base\Collection\Contracts\SortInterface;
use LDL\Framework\Base\Collection\Exception\SortException;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\HasSortValueInterface;
use LDL\Framework\Base\Exception\InvalidArgumentException;

/**
 * Trait SortInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see SortInterface
 */
trait SortInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * Returns a new collection instance, sorted by value.
     *
     * @param string $sort
     * @param string $order
     * @return CollectionInterface
     * @throws \LDL\Framework\Base\Exception\RuntimeException
     * @throws LockingException
     */
    public function sort(string $sort = Constants::SORT_ASCENDING, string $order = Constants::COMPARE_LTR): CollectionInterface
    {
        $fn = static function ($a, $b) use ($sort, $order) {

            $aInstanceOfSort = $a instanceof HasSortValueInterface;
            $bInstanceOfSort = $b instanceof HasSortValueInterface;

            if (is_object($a) && !$aInstanceOfSort) {
                throw new SortException(sprintf('Instance of class "%s" does NOT implements "%s", thus it can\'t be sorted', get_class($a), HasSortValueInterface::class));
            }

            if (is_object($b) && !$bInstanceOfSort) {
                throw new SortException(sprintf('Instance of class "%s" does NOT implements "%s", thus it can\'t be sorted', get_class($b), HasSortValueInterface::class));
            }

            $a = $aInstanceOfSort ? $a->getSortValue() : $a;
            $b = $bInstanceOfSort ? $b->getSortValue() : $b;

            if (!is_scalar($a) || !is_scalar($b)) {
                throw new InvalidArgumentException("Sortable value or object property should be scalar.");
            }

            if (ComparisonOperatorHelper::compare($a, $b, Constants::OPERATOR_EQ)) {
                return 0;
            }

            $comparison = ComparisonOperatorHelper::compare($a, $b, Constants::OPERATOR_GT, $order);

            if ($sort === Constants::SORT_ASCENDING) {
                return $comparison ? 1 : -1;
            }

            if ($sort === Constants::SORT_DESCENDING) {
                return $comparison ? -1 : 1;
            }
        };

        return $this->sortByCallback($fn);
    }

    /**
     * Returns a new instance, sorted by value through an anonymous comparison function
     *
     * @param callable $fn
     * @return CollectionInterface
     * @throws \LDL\Framework\Base\Exception\RuntimeException
     * @throws LockingException
     */
    public function sortByCallback(callable $fn): CollectionInterface
    {
        if($this instanceof LockableObjectInterface && $this->isLocked()){
            throw new LockingException('Can not sort collection by value, collection is locked!');
        }

        $this->requireTraits([CollectionInterfaceTrait::class]);
        $this->requireImplements([SortInterface::class]);
        $items = $this->toArray(true);
        uasort($items, $fn);
        $this->setItems($items);

        return $this;
    }
}
