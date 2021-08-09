<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;

trait HasDuplicateKeyVerificationAppendInterfaceTrait
{
    /**
     * @var CallableCollectionInterface
     */
    private $_tHasAppendDuplicateKey;

    //<editor-fold desc="HasDuplicateKeyVerificationAppendInterface methods">
    public function onAppendDuplicateKey() : CallableCollectionInterface
    {
        if(null === $this->_tHasAppendDuplicateKey){
            $this->_tHasAppendDuplicateKey = new CallableCollection();
        }

        return $this->_tHasAppendDuplicateKey;
    }
    //</editor-fold>
}