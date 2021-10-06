<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Constants;

interface SortableScalarInterface extends SortInterface
{
    /**
     * Sorts a scalar collection
     *
     * NOTE: Please note that if there are no scalar items the returned collection will be empty.
     * Only scalar values will be taken into consideration while sorting,
     * if you have a mixed collection, i.e: a collection containing some Object or some other
     * type of data the rest of the elements will be discarded.
     *
     * @param string $sort, the order in which to sort, order must be one of:
     *
     *  Constants::SORT_ASCENDING
     *  Constants::SORT_DESCENDING
     *
     * @see SortInterface
     *
     * @return CollectionInterface
     */
    public function sortScalar(string $sort=Constants::SORT_ASCENDING) : CollectionInterface;
}