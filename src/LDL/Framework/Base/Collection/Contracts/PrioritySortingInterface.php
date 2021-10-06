<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface PrioritySortingInterface extends SortInterface
{
    /**
     * Sorts a collection which contains PriorityInterface objects.
     *
     * NOTE: Please note that if there are no PriorityInterface objects the returned collection will be empty.
     * Only objects which implement PriorityInterface will be taken into consideration while sorting,
     * if you have a mixed collection, i.e: a collection containing some PriorityInterface objects and some other
     * type of data (such as a string or whatever data type) the rest of the elements will be discarded.
     *
     * @param string $order, the order in which to sort, order must be one of:
     *
     *  Constants::SORT_ASCENDING
     *  Constants::SORT_DESCENDING
     *
     * @see SortInterface
     * @see PriorityInterface
     *
     * @return CollectionInterface
     */
    public function sortByPriority(string $order) : CollectionInterface;
}