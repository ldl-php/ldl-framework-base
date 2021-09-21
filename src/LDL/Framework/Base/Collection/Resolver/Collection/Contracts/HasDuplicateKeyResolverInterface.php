<?php declare(strict_types=1);

/**
 * HasDuplicateKeyResolver must be used when the key already exists and something can be done to get a new
 * non-conflicting key, for example, if the collection contains a key named 'test' and if I append a item
 * with the same key ('test') then I would return a new key based (or not) on the passed 'test' key
 * for example 'test_1' If the collection still has the key after trying to obtain a new
 * non-conflicting key, an exception must be thrown.
 */
namespace LDL\Framework\Base\Collection\Resolver\Collection\Contracts;

use LDL\Framework\Base\Collection\Resolver\Collection\DuplicateResolverCollectionInterface;

/**
 * Interface HasDuplicateKeyResolverInterface
 * @package LDL\Framework\Base\Collection\Resolver\Collection
 */
interface HasDuplicateKeyResolverInterface
{
    public function getDuplicateKeyResolver() : DuplicateResolverCollectionInterface;
}