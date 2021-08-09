<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Contracts;

use LDL\Framework\Base\Collection\CallableCollectionInterface;

interface HasDuplicateKeyVerificationInterface
{
    /**
     * @return CallableCollectionInterface
     */
    public function onDuplicateKey() : CallableCollectionInterface;
}