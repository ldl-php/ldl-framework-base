<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Helper\ClassHelper;

class Test
{
    use \LDL\Framework\Base\Collection\Traits\AppendableInterfaceTrait;
}

echo "Get CallableCollection traits\n";
var_dump(ClassHelper::getAllTraits(Test::class));

$class = new Test();
$class->append('lala');
