<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Traits;

use LDL\Framework\Base\Collection\Key\Resolver\Collection\DuplicateResolverCollection;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\DuplicateResolverCollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\DecimalKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerDuplicateKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\ObjectDuplicateKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\StringDuplicateKeyResolver;

trait HasKeyResolverInterfaceTrait
{
    /**
     * @var DuplicateResolverCollectionInterface
     */
    private $_tKeyResolver;

    public function getKeyResolver() : DuplicateResolverCollectionInterface
    {
        if(null === $this->_tKeyResolver){
            return $this->_tKeyResolver = new DuplicateResolverCollection([
                new IntegerDuplicateKeyResolver(),
                new DecimalKeyResolver(),
                new StringDuplicateKeyResolver(),
                new ObjectDuplicateKeyResolver()
            ]);
        }

        return $this->_tKeyResolver;
    }
}