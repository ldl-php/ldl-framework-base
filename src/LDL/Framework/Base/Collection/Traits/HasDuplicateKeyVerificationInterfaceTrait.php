<?php declare(strict_types=1);

/**
 * This trait contains common functionality that can be applied to any collection
 */

namespace LDL\Framework\Base\Collection\Traits;

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Collection\CallableCollectionInterface;

trait HasDuplicateKeyVerificationInterfaceTrait
{
    /**
     * @var CallableCollectionInterface
     */
    private $_tHasDuplicateKey;

    //<editor-fold desc="HasDuplicateKeyVerificationInterface methods">
    public function onDuplicateKey() : CallableCollectionInterface
    {
        if(null === $this->_tHasDuplicateKey){
            $this->_tHasDuplicateKey = new CallableCollection();
        }

        return $this->_tHasDuplicateKey;
    }
    //</editor-fold>
}