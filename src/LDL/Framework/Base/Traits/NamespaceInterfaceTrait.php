<?php declare(strict_types=1);

/**
 * Trait which implements NamespaceInterface
 * @see \LDL\Framework\Base\Contracts\NamespaceInterface
 */

namespace LDL\Framework\Base\Traits;

trait NamespaceInterfaceTrait
{
    /**
     * This is intentionally left uninitialized to force initialization when this trait is used in a class
     * @var string
     */
    private $_tNamespace;

    /**
     * This is intentionally left uninitialized to force initialization when this trait is used in a class
     * @var string
     */
    private $_tName;

    public function getNamespace(): string
    {
        return $this->_tNamespace;
    }

    public function getName() : string
    {
        return $this->_tName;
    }

}