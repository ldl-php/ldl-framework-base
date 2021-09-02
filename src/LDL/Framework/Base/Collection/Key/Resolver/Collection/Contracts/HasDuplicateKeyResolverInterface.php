<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts;

use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollectionInterface;

interface HasDuplicateKeyResolverInterface
{

    /**
     * @return KeyResolverCollectionInterface
     */
    public function getDuplicateKeyResolver() : KeyResolverCollectionInterface;

}