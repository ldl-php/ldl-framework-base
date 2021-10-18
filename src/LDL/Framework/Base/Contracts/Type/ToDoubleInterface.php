<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToDoubleInterface
{
    /**
     * @return float
     */
    public function toDouble() : float;
}
