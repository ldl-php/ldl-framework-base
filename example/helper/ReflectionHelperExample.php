<?php declare(strict_types=1);

class MyGlobalClass{

}

namespace My\First\Ns;

require __DIR__.'/../../vendor/autoload.php';

interface ReflectionHelperExampleInterfaceOne { }

trait MyTraitOne{ }

class ReflectionHelperExampleOne{ }

namespace My\Second\Ns;

use LDL\Framework\Helper\ReflectionHelper;

trait MyTraitTwo{ }

class ReflectionHelperExampleTwo { }

interface ReflectionHelperExampleInterfaceTwo { }

echo "Call ReflectionHelper::fromFile(__FILE__)\n";
var_dump(ReflectionHelper::fromFile(__FILE__));