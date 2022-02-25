<?php

declare(strict_types=1);

/**
 * Trait which complies to NamespaceInterface.
 *
 * @see \LDL\Framework\Base\Contracts\NamespaceInterface
 */

namespace LDL\Framework\Base\Traits;

trait NamespaceInterfaceTrait
{
    use NameableTrait;
    /**
     * This is intentionally left uninitialized to force initialization when this trait is used in a class.
     *
     * @var string
     */
    private $_tNamespace;

    public function getNamespace(): string
    {
        return $this->_tNamespace;
    }
}
