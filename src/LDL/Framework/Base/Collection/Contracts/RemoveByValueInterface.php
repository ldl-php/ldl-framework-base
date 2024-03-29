<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\LockRemoveException;

interface RemoveByValueInterface
{
    /**
     * Removes elements from a collection by value comparison
     *
     * Order of comparison is: $value <OPERATOR> $collectionValue
     * Example: given a collection of five numbers 1,2,3,4,5, and given the $value 3
     * and the operator Constants::OPERATOR_GTE
     * The comparison would be resolved as
     *
     * 1 >= 3
     * 2 >= 3
     * 3 >= 3 ... etc
     *
     * When this process is finished you must end up with a collection which only contains
     * numbers 3, 4 and 5.
     *
     *
     * @param $value
     * @param string $operator
     * @param string $order Comparison order (Constants::ORDER_LTR | Constants::ORDER_RTL)
     * @throws LockRemoveException
     * @return int Returns 0 if no elements have been removed, > 0 when elements have been removed
     */
    public function removeByValue($value, string $operator, string $order) : int;
}