<?php declare(strict_types=1);
/**
 * HasNullResolverInterface must be executed only when a key has not been specified (i.e: $key = null), this
 * generates a key regarding to your own logic, but it must be executed ONLY when the specified key is null.
 *
 * NOTE: If you would implement both HasCustomResolverInterface and HasNullResolverInterface,
 * HasNullResolverInterface would only be executed if your HasCustomResolverInterface would return null.
 */

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts;

use LDL\Framework\Base\Collection\Key\Resolver\Contracts\CustomResolverInterface;

/**
 * Interface HasNullResolverInterface
 * @package LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts
 */

interface HasNullResolverInterface
{

    /**
     * @return CustomResolverInterface
     */
    public function getNullResolver() : CustomResolverInterface;

}