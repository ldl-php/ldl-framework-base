<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts\Append;

use LDL\Framework\Base\Collection\Key\Resolver\Contracts\DuplicateResolverInterface;

interface HasAppendDuplicateResolverInterface
{

    public function getAppendDuplicateResolver() : DuplicateResolverInterface;

}