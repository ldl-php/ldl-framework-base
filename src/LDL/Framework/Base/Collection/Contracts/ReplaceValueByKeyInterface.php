<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface ReplaceValueByKeyInterface
{
    /**
     * @param $key
     * @param $replacement
     * @param bool $useKeys
     * @param string $operator
     * @param string $order
     * @return int
     */
    public function replaceValueByKey($key, $replacement, bool $useKeys, string $operator, string $order) : int;
}