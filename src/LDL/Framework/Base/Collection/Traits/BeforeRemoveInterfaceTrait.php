<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;

trait BeforeRemoveInterfaceTrait
{
    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeRemove;

    public function getBeforeRemove() : CallableCollectionInterface
    {
        if(null === $this->_tBeforeRemove){
            $this->_tBeforeRemove = new CallableCollection();
        }

        return $this->_tBeforeRemove;
    }

}