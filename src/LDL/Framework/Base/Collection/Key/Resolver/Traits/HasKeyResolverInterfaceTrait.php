<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Traits;

use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollection;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\KeyResolverCollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\FloatKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\ObjectKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\StringKeyResolver;

trait HasKeyResolverInterfaceTrait
{
    /**
     * @var KeyResolverCollectionInterface
     */
    private $_tKeyResolver;

    public function getKeyResolver() : KeyResolverCollectionInterface
    {
        if(null === $this->_tKeyResolver){
            return $this->_tKeyResolver = new KeyResolverCollection([
                new IntegerKeyResolver(),
                new FloatKeyResolver(),
                new StringKeyResolver(),
                new ObjectKeyResolver()
            ]);
        }

        return $this->_tKeyResolver;
    }
}