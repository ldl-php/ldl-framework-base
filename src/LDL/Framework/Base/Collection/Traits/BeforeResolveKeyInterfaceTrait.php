<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeResolveKeyInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait BeforeResolveKeyInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeResolveKey;

    //<editor-fold desc="BeforeResolveKeyInterface methods">
    public function getBeforeResolveKey() : CallableCollectionInterface
    {
        $this->requireImplements([BeforeResolveKeyInterface::class]);

        if(null === $this->_tBeforeResolveKey){
            $this->_tBeforeResolveKey = new CallableCollection();
        }

        return $this->_tBeforeResolveKey;
    }
    //</editor-fold>
}