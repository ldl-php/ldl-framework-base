<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\ReplaceException;

interface ReplaceByKeyInterface
{
    /**
     * Replaces a $key in a collection with a $newKey and an OPTIONAL $replacement.
     * If $replacement is exactly equal to null the value must remain, if it's not
     * the value must also be replaced.
     *
     * @param string|int $key
     * @param string|int $newKey
     * @param null|mixed $replacement
     * @param string $operator
     * @param string $order
     * @return int Returns the amount of elements that were replaced
     * @throws ReplaceException
     */
    public function replaceByKey($key, $newKey, $replacement, string $operator, string $order) : int;
}