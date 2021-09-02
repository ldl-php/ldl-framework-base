<?php declare(strict_types=1);

/**
 * HasCustomKeyResolverInterface must be executed only if the given collection implements said key resolver,
 * this is useful when, for example, you'd like to enforce a certain key format and disregard any user input, in that
 * case, this is the interface that would be implemented.
 *
 * NOTE: if implemented, this must be executed regardless of the $key having whatever value (null, string, etc).
 *
 * Practical example: You have a collection of RouteInterface objects, you want each key to be
 * the RouteInterface::getName() : string value
 */

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection;

use LDL\Framework\Base\Collection\Key\Resolver\Contracts\CustomKeyResolverInterface;

/**
 * Interface HasCustomKeyResolverInterface
 * @package LDL\Framework\Base\Collection\Key\Resolver\Collection
 */
interface HasCustomKeyResolverInterface
{

    public function getCustomKeyResolver() : CustomKeyResolverInterface;

}