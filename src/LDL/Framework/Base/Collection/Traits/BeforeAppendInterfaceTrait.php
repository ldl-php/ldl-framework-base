<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

trait BeforeAppendInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeAppend;

    //<editor-fold desc="BeforeAppendInterface methods">
    public function getBeforeAppend() : CallableCollectionInterface
    {
        $this->requireImplements([BeforeAppendInterface::class]);

        if(null === $this->_tBeforeAppend){
            $this->_tBeforeAppend = new CallableCollection();
        }

        return $this->_tBeforeAppend;
    }
    //</editor-fold>
}