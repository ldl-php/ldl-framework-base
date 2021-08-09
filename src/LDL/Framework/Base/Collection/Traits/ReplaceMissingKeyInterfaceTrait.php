<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;

trait ReplaceMissingKeyInterfaceTrait
{
    /**
     * @var CallableCollectionInterface
     */
    private $_tHasReplaceMissingKey;

    //<editor-fold desc="ReplaceMissingKeyInterface methods">
    public function onReplaceMissingKey() : CallableCollectionInterface
    {
        if(null === $this->_tHasReplaceMissingKey){
            $this->_tHasReplaceMissingKey = new CallableCollection();
        }

        return $this->_tHasReplaceMissingKey;
    }
    //</editor-fold>
}