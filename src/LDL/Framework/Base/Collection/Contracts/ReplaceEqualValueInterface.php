<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\Exception\ReplaceException;

interface ReplaceEqualValueInterface
{
    /**
     * @param $value
     * @param $replacement
     * @param bool $strict
     * @param int|null $limit
     * @return CollectionInterface
     * @throws ReplaceException
     */
    public function replaceByEqualValue($value, $replacement, bool $strict = true, int $limit = null) : CollectionInterface;
}