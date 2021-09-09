<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface ReplaceByCallbackInterface
{
    /**
     * @param callable $func
     * @param $replacement
     * @param bool $useKeys
     * @return int
     */
    public function replaceByCallback(callable $func, $replacement, bool $useKeys) : int;
}