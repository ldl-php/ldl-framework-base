<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToDoubleInterface extends LDLTypeInterface
{
    /**
     * @return float
     */
    public function toDouble() : float;
}
