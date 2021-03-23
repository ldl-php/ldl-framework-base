<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;

trait BeforeAppendInterfaceTrait
{
    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeAppend;

    public function getBeforeAppend() : CallableCollectionInterface
    {
        if(null === $this->_tBeforeAppend){
            $this->_tBeforeAppend = new CallableCollection();
        }

        return $this->_tBeforeAppend;
    }

}