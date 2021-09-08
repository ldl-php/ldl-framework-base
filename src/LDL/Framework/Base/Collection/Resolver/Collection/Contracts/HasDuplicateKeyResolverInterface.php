<?php declare(strict_types=1);

/**
 * HasDuplicateKeyResolver must be used when the key already exists and something can be done to get a new
 * non-conflicting key, for example, if I append a item with a key named 'test' then I would return a new key based on
 * the passed 'test' key, for example 'test_1' If the collection still has the key after trying to obtain a new
 * non-conflicting key, an exception must be thrown.
 */
namespace LDL\Framework\Base\Collection\Resolver\Collection\Contracts;

use LDL\Framework\Base\Collection\Resolver\Contracts\DuplicateResolverInterface;

/**
 * Interface HasDuplicateKeyResolverInterface
 * @package LDL\Framework\Base\Collection\Resolver\Collection
 */
interface HasDuplicateKeyResolverInterface
{
    public function getDuplicateKeyResolver() : DuplicateResolverInterface;
}