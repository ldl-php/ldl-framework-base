<?php

declare(strict_types=1);

/**
 * Trait which complies to NameableInterface.
 *
 * @see \LDL\Framework\Base\Contracts\NameableInterface
 */

namespace LDL\Framework\Base\Traits;

trait NameableTrait
{
    /**
     * This is intentionally left uninitialized to force initialization when this trait is used in a class.
     *
     * @var string
     */
    private $_tName;

    public function getName(): string
    {
        return $this->_tName;
    }
}
