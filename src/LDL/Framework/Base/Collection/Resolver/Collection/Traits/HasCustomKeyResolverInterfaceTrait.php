<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection\Traits;

use LDL\Framework\Base\Collection\Resolver\Collection\CustomResolverCollection;
use LDL\Framework\Base\Collection\Resolver\Collection\CustomResolverCollectionInterface;

trait HasCustomKeyResolverInterfaceTrait
{
    /**
     * @var CustomResolverCollectionInterface
     */
    private $_tCustomKeyResolver;

    //<editor-fold desc="HasCustomKeyResolverInterface methods>
    public function getCustomKeyResolver() : CustomResolverCollectionInterface
    {
        if(null === $this->_tCustomKeyResolver){
            return $this->_tCustomKeyResolver = new CustomResolverCollection();
        }

        return $this->_tCustomKeyResolver;
    }
    //</editor-fold>
}