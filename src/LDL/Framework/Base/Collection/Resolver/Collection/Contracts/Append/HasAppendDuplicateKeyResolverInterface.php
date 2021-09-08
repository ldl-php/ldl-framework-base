<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection\Contracts\Append;

use LDL\Framework\Base\Collection\Resolver\Contracts\DuplicateResolverInterface;

interface HasAppendDuplicateKeyResolverInterface
{

    public function getAppendDuplicateKeyResolver() : DuplicateResolverInterface;

}