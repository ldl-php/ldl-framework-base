<?php declare(strict_types=1);

namespace LDL\Framework\Base\Collection;

use LDL\Framework\Base\Collection\Contracts\AppendableInterface;
use LDL\Framework\Base\Collection\Contracts\BeforeAppendInterface;
use LDL\Framework\Base\Collection\Contracts\CollectionInterface;
use LDL\Framework\Base\Collection\Contracts\LockAppendInterface;
use LDL\Framework\Base\Collection\Contracts\LockRemoveInterface;
use LDL\Framework\Base\Collection\Contracts\RemovableInterface;
use LDL\Framework\Base\Contracts\LockableObjectInterface;

interface ArrayKeyCollectionInterface extends CollectionInterface, AppendableInterface, LockAppendInterface, RemovableInterface, LockRemoveInterface, LockableObjectInterface, BeforeAppendInterface
{

}