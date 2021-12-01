<?php

declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Constants;
use LDL\Framework\Base\Collection\Exception\SortException;
use LDL\Framework\Base\Exception\InvalidArgumentException;
use LDL\Framework\Base\Collection\Contracts\HasSortValueInterface;

final class SortHelper
{    
    /**
     * sort items by value
     *
     * @param  string $sort
     * @param  array $items
     * @return array
     */
    public static function sort(string $sort = Constants::SORT_ASCENDING, array $items)
    {
        $fn = static function ($a, $b) use ($sort) {

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

            $comparison = (string) $a <=> (string) $b;

            if($comparison == 0) {
                return $comparison;
            }

            if($sort == Constants::SORT_DESCENDING) {
                $comparison = $comparison > 0 ? -1 : 1;
            }

            return $comparison;
        };
        
        return self::sortByCallback($fn, $items);
    }
    
    /**
     * sort items by callable function
     *
     * @param  callable $fn
     * @param  array $items
     * @return array
     */
    public static function sortByCallback(callable $fn, array $items)
    {
        uasort($items, $fn);

        return $items;
    }

    /**
     * sort items by key
     *
     * @param  string $sort
     * @param  array $items
     * @return array
     */
    public static function ksort(string $sort = Constants::SORT_ASCENDING, array $items)
    {
        $fn = static function ($a, $b) use ($sort) {
            $comparison = (string) $a <=> (string) $b;

            if($comparison == 0) {
                return $comparison;
            }

            if($sort == Constants::SORT_DESCENDING) {
                $comparison = $comparison > 0 ? -1 : 1;
            }

            return $comparison;
        };

        return self::keySortByCallback($fn, $items);
    }

    /**
     * sort item keys by callable function
     *
     * @param  callable $fn
     * @param  array $items
     * @return array
     */
    public static function keySortByCallback(callable $fn, array $items)
    {
        uksort($items, $fn);

        return $items;
    }
}
