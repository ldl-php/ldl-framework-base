<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Traits;

use LDL\Framework\Base\Collection\Resolver\Collection\DuplicateResolverCollection;
use LDL\Framework\Base\Collection\Resolver\Collection\DuplicateResolverCollectionInterface;
use LDL\Framework\Base\Collection\Resolver\Key\DecimalKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\IntegerKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\HasObjectKeyResolver;
use LDL\Framework\Base\Collection\Resolver\Key\StringKeyResolver;

trait HasAppendKeyResolverInterfaceTrait
{
    /**
     * @var DuplicateResolverCollectionInterface
     */
    private $_tAppendKeyResolver;

    public function getAppendKeyResolver() : DuplicateResolverCollectionInterface
    {
        if(null === $this->_tAppendKeyResolver){
            return $this->_tAppendKeyResolver = new DuplicateResolverCollection([
                new IntegerKeyResolver(),
                new DecimalKeyResolver(),
                new StringKeyResolver(),
                new HasObjectKeyResolver()
            ]);
        }

        return $this->_tAppendKeyResolver;
    }
}