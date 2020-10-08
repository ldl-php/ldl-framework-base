<?php declare(strict_types=1);

/**
 * Trait which implements IsActiveInterface
 * @see \LDL\Framework\Base\Contracts\IsActiveInterface
 */

namespace LDL\Framework\Base\Traits;

trait PriorityInterfaceTrait
{
    /**
     * This is intentionally left uninitialized to force initialization when this trait is used in a class
     * @var int
     */
    private $_tPriority;

    public function getPriority() : int
    {
        return $this->_tPriority;
    }
}