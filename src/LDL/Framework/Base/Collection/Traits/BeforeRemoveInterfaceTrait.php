<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Helper\ClassRequirementHelperTrait;

/**
 * Trait BeforeRemoveInterfaceTrait
 * @package LDL\Framework\Base\Collection\Traits
 * @see BeforeRemoveInterface
 */
trait BeforeRemoveInterfaceTrait
{
    use ClassRequirementHelperTrait;

    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeRemove;

    //<editor-fold desc="BeforeRemoveInterface methods">
    public function getBeforeRemove() : CallableCollectionInterface
    {
        $this->requireImplements([BeforeRemoveInterface::class]);

        if(null === $this->_tBeforeRemove){
            $this->_tBeforeRemove = new CallableCollection();
        }

        return $this->_tBeforeRemove;
    }
    //</editor-fold>
}