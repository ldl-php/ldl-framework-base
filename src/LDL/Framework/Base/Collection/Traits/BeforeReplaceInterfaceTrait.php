<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;

trait BeforeReplaceInterfaceTrait
{
    /**
     * @var CallableCollectionInterface
     */
    private $_tBeforeReplace;

    public function getBeforeReplace() : CallableCollectionInterface
    {
        if(null === $this->_tBeforeReplace){
            $this->_tBeforeReplace = new CallableCollection();
        }

        return $this->_tBeforeReplace;
    }

}