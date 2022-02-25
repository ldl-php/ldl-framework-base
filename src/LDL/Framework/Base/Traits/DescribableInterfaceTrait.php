<?php

declare(strict_types=1);

/**
 * Trait which complies to DescribableInterface.
 *
 * @see \LDL\Framework\Base\Contracts\NameableInterface
 */

namespace LDL\Framework\Base\Traits;

trait DescribableInterfaceTrait
{
    /**
     * This is intentionally left uninitialized to force initialization when this trait is used in a class.
     *
     * @var string
     */
    private $_tDescription;

    public function getDescription(): string
    {
        return $this->_tDescription;
    }
}
