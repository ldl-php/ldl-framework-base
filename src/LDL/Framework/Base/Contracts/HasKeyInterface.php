<?php declare(strict_types=1);

namespace LDL\Framework\Base\Contracts;

interface HasKeyInterface
{
    /**
     * @return string
     */
    public function getObjectKey() : string;
}