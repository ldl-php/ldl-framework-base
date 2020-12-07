<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

interface NameableInterface
{
    /**
     * @return string
     */
    public function getName() : string;
}