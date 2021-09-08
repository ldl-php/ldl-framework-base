<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Base\Collection\Resolver\Collection\Contracts\HasValueResolverInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait HasValueResolverInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var CallableCollectionInterface
     */
    private $_tResolveValue;

    //<editor-fold desc="HasValueResolverInterface methods">
    public function getValueResolver() : CallableCollectionInterface
    {
        $this->requireImplements([HasValueResolverInterface::class]);

        if(null === $this->_tResolveValue){
            $this->_tResolveValue = new CallableCollection();
        }

        return $this->_tResolveValue;
    }
    //</editor-fold>
}