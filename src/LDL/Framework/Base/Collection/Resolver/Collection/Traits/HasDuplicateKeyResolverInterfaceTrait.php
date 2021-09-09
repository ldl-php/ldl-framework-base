<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection\Traits;

use LDL\Framework\Base\Collection\Resolver\Collection\DuplicateResolverCollection;
use LDL\Framework\Base\Collection\Resolver\Collection\DuplicateResolverCollectionInterface;

trait HasDuplicateKeyResolverInterfaceTrait
{
    /**
     * @var DuplicateResolverCollectionInterface
     */
    private $_tDuplicateKeyResolver;

    //<editor-fold desc="HasDuplicateKeyResolverInterface methods>
    public function getDuplicateKeyResolver() : DuplicateResolverCollectionInterface
    {
        if(null === $this->_tDuplicateKeyResolver){
            return $this->_tDuplicateKeyResolver = new DuplicateResolverCollection();
        }

        return $this->_tDuplicateKeyResolver;
    }
    //<editor-fold>
}