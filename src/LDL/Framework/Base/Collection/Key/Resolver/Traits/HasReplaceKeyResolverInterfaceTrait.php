<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Traits;

use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollection;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\StringKeyResolver;

trait HasReplaceKeyResolverInterfaceTrait
{
    /**
     * @var KeyResolverCollectionInterface
     */
    private $_tReplaceKeyResolver;

    public function getReplaceKeyResolver() : KeyResolverCollectionInterface
    {
        if(null === $this->_tReplaceKeyResolver){
            return $this->_tReplaceKeyResolver = new KeyResolverCollection([
                new IntegerKeyResolver(),
                new StringKeyResolver()
            ]);
        }

        return $this->_tReplaceKeyResolver;
    }
}