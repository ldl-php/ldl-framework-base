<?php declare(strict_types=1);
/**
 * HasNullKeyResolverInterface must be executed only when a key has not been specified (i.e: $key = null), this
 * generates a key regarding to your own logic, but it must be executed ONLY when the specified key is null.
 *
 * NOTE: If you would implement both HasCustomKeyResolverInterface and HasNullKeyResolverInterface,
 * HasNullKeyResolverInterface would only be executed if your HasCustomKeyResolverInterface would return null.
 */

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts;

use LDL\Framework\Base\Collection\Key\Resolver\Contracts\CustomKeyResolverInterface;

/**
 * Interface HasNullKeyResolverInterface
 * @package LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts
 */

interface HasNullKeyResolverInterface
{

    /**
     * @return CustomKeyResolverInterface
     */
    public function getNullKeyResolver() : CustomKeyResolverInterface;

}