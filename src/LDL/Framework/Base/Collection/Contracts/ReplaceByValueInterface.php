<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\ReplaceException;

interface ReplaceByValueInterface
{
    /**
     * @param mixed $value
     * @param mixed $replacement
     * @param bool $useKeys
     * @param string $operator
     * @param string $order
     * @return int Returns the amount of elements that were replaced
     * @throws ReplaceException
     */
    public function replaceByValue($value, $replacement, bool $useKeys, string $operator, string $order) : int;
}