<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Traits;

use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollection;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\StringKeyResolver;

trait HasDuplicateKeyResolverInterfaceTrait
{
    /**
     * @var KeyResolverCollectionInterface
     */
    private $_tDuplicateKeyResolver;

    public function getDuplicateKeyResolver() : KeyResolverCollectionInterface
    {
        if(null === $this->_tDuplicateKeyResolver){
            return $this->_tDuplicateKeyResolver = new KeyResolverCollection([
                new IntegerKeyResolver(),
                new StringKeyResolver()
            ]);
        }

        return $this->_tDuplicateKeyResolver;
    }
}