<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeReplaceInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

/**
 * Trait BeforeReplaceInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see BeforeReplaceInterface
 */
trait BeforeReplaceInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeReplace;

    //<editor-fold desc="BeforeReplaceInterface methods">
    public function getBeforeReplace() : CallableCollectionInterface
    {
        $this->requireImplements([BeforeReplaceInterface::class]);

        if(null === $this->_tBeforeReplace){
            $this->_tBeforeReplace = new CallableCollection();
        }

        return $this->_tBeforeReplace;
    }
    //</editor-fold>
}