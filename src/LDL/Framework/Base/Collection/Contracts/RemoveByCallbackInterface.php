<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

interface RemoveByCallbackInterface
{
    /**
     * @param callable $func
     * @return int
     */
    public function removeByCallback(callable $func) : int;
}