<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts\Append;

use LDL\Framework\Base\Collection\Key\Resolver\Contracts\NullKeyResolverInterface;

interface HasAppendNullKeyResolverInterface
{

    public function getAppendNullKeyResolver() : NullKeyResolverInterface;

}