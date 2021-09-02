<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Contracts;

interface ObjectKeyResolverInterface
{

    /**
     * @return string|int|float|null
     */
    public function getObjectKey();

}