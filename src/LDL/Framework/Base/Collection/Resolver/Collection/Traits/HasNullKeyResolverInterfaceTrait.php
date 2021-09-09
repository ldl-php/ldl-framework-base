<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection\Traits;

use LDL\Framework\Base\Collection\Resolver\Collection\NullResolverCollection;
use LDL\Framework\Base\Collection\Resolver\Collection\NullResolverCollectionInterface;

trait HasNullKeyResolverInterfaceTrait
{
    /**
     * @var NullResolverCollectionInterface
     */
    private $_tNullKeyResolver;

    //<editor-fold desc="HasCustomKeyResolverInterface methods>
    public function getCustomKeyResolver() : NullResolverCollectionInterface
    {
        if(null === $this->_tNullKeyResolver){
            return $this->_tNullKeyResolver = new NullResolverCollection();
        }

        return $this->_tNullKeyResolver;
    }
    //</editor-fold>
}