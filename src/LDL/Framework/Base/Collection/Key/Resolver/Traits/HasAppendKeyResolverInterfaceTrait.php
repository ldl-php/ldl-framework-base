<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Traits;

use LDL\Framework\Base\Collection\Key\Resolver\Collection\DuplicateKeyResolverCollection;
use LDL\Framework\Base\Collection\Key\Resolver\Collection\DuplicateKeyResolverCollectionInterface;
use LDL\Framework\Base\Collection\Key\Resolver\DecimalKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\IntegerDuplicateKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\ObjectDuplicateKeyResolver;
use LDL\Framework\Base\Collection\Key\Resolver\StringDuplicateKeyResolver;

trait HasAppendKeyResolverInterfaceTrait
{
    /**
     * @var DuplicateKeyResolverCollectionInterface
     */
    private $_tAppendKeyResolver;

    public function getAppendKeyResolver() : DuplicateKeyResolverCollectionInterface
    {
        if(null === $this->_tAppendKeyResolver){
            return $this->_tAppendKeyResolver = new DuplicateKeyResolverCollection([
                new IntegerDuplicateKeyResolver(),
                new DecimalKeyResolver(),
                new StringDuplicateKeyResolver(),
                new ObjectDuplicateKeyResolver()
            ]);
        }

        return $this->_tAppendKeyResolver;
    }
}