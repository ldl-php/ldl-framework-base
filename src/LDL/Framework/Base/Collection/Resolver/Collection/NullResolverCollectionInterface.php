<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection\Resolver\Collection;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Collection\Resolver\Contracts\NullResolverInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;

interface NullResolverCollectionInterface extends CollectionInterface, LockableObjectInterface, BeforeAppendInterface, AppendableInterface, LockAppendInterface, BeforeRemoveInterface, RemovableInterface, LockRemoveInterface, NullResolverInterface
{

}