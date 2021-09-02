<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts;

use LDL\Framework\Base\Collection\Key\Resolver\KeyResolverCollectionInterface;

interface HasAppendKeyResolverInterface
{

    /**
     * @return KeyResolverCollectionInterface
     */
    public function getAppendKeyResolver() : KeyResolverCollectionInterface;

}