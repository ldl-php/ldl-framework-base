<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts\Type;

interface ToIntInterface extends LDLTypeInterface
{

    public function toInt() : int;

}
