<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Base\Constants;
use LDL\Framework\Helper\IterableHelper;
use LDL\Framework\Base\Contracts\Type\ToIntegerInterface;
use LDL\Framework\Base\Contracts\Type\ToDoubleInterface;
use LDL\Framework\Base\Contracts\Type\ToArrayInterface;
use LDL\Framework\Base\Contracts\Type\ToStringInterface;

echo "Create array of 7 elements:\n\n";

class IntClass implements ToIntegerInterface
{
    public function toInteger(): int
    {
        return 99;
    }
}

class DoubleClass implements ToDoubleInterface
{
    public function toDouble(): float
    {
        return 1.01;
    }
}

class ArrayClass implements ToArrayInterface
{
    public function toArray(bool $useKeys = null): array
    {
        return [-10,-100,'text'];
    }
}

class StringClass implements ToStringInterface
{
    public function toString(): string
    {
        return 'StringClass';
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}

$dp = opendir(sys_get_temp_dir());

$items = [
    0x25,
    0b01001,
    '5 dogs',
    '10',
    9e99,
    0,
    -1,
    $dp,
    null,
    [],
    new IntClass(),
    new DoubleClass(),
    new ArrayClass(),
    new StringClass(),
    true
];

foreach(Constants::getTypeConstants() as $name=>$filter){
    echo sprintf("Filter items by %s: %s\n" , $name, $filter);
    echo str_repeat('#', 80)."\n\n";
    echo var_dump(IterableHelper::filterByValueType($items, $filter))."\n";
}

closedir($dp);
