<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Traits;

use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollection;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\StringKeyResolver;

trait HasAppendKeyResolverInterfaceTrait
{
    /**
     * @var KeyResolverCollectionInterface
     */
    private $_tAppendKeyResolver;

    public function getAppendKeyResolver() : KeyResolverCollectionInterface
    {
        if(null === $this->_tAppendKeyResolver){
            return $this->_tAppendKeyResolver = new KeyResolverCollection([
                new IntegerKeyResolver(),
                new StringKeyResolver()
            ]);
        }

        return $this->_tAppendKeyResolver;
    }
}