<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Helper\ArrayHelper\Exception\InvalidKeyException;
use LDL\Framework\Base\Collection\Exception\RemoveException;
use LDL\Framework\Base\Exception\LockingException;
use LDL\Framework\Helper\ComparisonOperatorHelper;

interface RemoveByKeyInterface
{
    /**
     * Remove an element from a collection by a specific key.
     *
     * @param string|int $key
     * @param string $operator
     * @param string $order
     * @throws LockingException
     * @throws InvalidKeyException
     *
     * @return int Returns 0 if no elements have been removed, > 0 when elements have been removed
     */
    public function removeByKey(
        $key,
        string $operator = ComparisonOperatorHelper::OPERATOR_SEQ,
        string $order = ComparisonOperatorHelper::COMPARE_LTR
    ) : int;

    /**
     * Remove last appended item
     *
     * @throws LockingException
     * @throws RemoveException
     * @return CollectionInterface
     */
    public function removeLast() : CollectionInterface;

}