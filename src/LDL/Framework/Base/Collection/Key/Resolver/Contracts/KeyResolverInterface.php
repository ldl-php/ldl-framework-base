<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Contracts;

use LDL\Framework\Base\Collection\Contracts\CollectionInterface;

interface KeyResolverInterface
{

    /**
     * @param CollectionInterface $collection
     * @param string|int|float|null $key
     * @param mixed $value
     * @return string|int|float|null
     */
    public function resolve(CollectionInterface $collection, $key, $value=null);

}