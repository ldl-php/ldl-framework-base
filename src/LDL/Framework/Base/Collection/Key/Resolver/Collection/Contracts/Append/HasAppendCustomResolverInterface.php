<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Key\Resolver\Collection\Contracts\Append;

use LDL\Framework\Base\Collection\Key\Resolver\Contracts\CustomResolverInterface;

interface HasAppendCustomResolverInterface
{

    public function getAppendCustomKeyResolver() : CustomResolverInterface;

}