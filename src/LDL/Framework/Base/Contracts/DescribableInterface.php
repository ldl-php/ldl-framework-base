<?php

declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

interface DescribableInterface
{
    public function getDescription(): string;
}
