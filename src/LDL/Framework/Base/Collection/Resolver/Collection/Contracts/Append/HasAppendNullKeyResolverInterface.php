<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection\Contracts\Append;

use LDL\Framework\Base\Collection\Resolver\Contracts\NullResolverInterface;

interface HasAppendNullKeyResolverInterface
{

    public function getAppendNullKeyResolver() : NullResolverInterface;

}