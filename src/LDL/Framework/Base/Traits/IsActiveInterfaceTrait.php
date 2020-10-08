<?php declare(strict_types=1);

/**
 * Trait which implements IsActiveInterface
 * @see \LDL\Framework\Base\Contracts\IsActiveInterface
 */

namespace LDL\Framework\Base\Traits;

trait IsActiveInterfaceTrait
{
    /**
     * @var bool
     */
    private $_tActive = true;

    public function isActive(): bool
    {
        return $this->_tActive;
    }
}