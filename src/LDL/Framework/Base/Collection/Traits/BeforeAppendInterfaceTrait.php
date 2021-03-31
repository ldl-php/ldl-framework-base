<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;

trait BeforeAppendInterfaceTrait
{
    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeAppendValue;

    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeAppendKey;

    public function getBeforeAppendValue() : CallableCollectionInterface
    {
        if(null === $this->_tBeforeAppendValue){
            $this->_tBeforeAppendValue = new CallableCollection();
        }

        return $this->_tBeforeAppendValue;
    }

    public function getBeforeAppendKey() : CallableCollectionInterface
    {
        if(null === $this->_tBeforeAppendKey){
            $this->_tBeforeAppendKey = new CallableCollection();
        }

        return $this->_tBeforeAppendKey;
    }
}