#!/usr/bin/env php
<?php declare(strict_types=1);

function runTest($file) : bool
{
    echo "\n\nRunning example: $file\n";
    echo str_repeat('#', 80)."\n\n\n";

    exec("php -f $file", $output, $return);

    echo implode("\n", $output);

    if(0 === $return){
        return true;
    }

    echo "TEST FAIL!!!!!\n";
    echo "$file\n";

    return false;
}

$dp = new DirectoryIterator(__DIR__);

$sleep = isset($_SERVER['argv'][1]) ? (int)$_SERVER['argv'][1] : 0;

foreach($dp as $file){

    if($file->isDir() || $file->getRealPath() === __FILE__ || $file->getExtension() !==  'php'){
        continue;
    }

    if(false === runTest($file->getRealPath())){
        exit(1);
    }

    if(0 === $sleep) {
        echo "\n\n";
        echo str_repeat('#', 80)."\n";
        echo "Press any key to continue ...\n";
        echo str_repeat('#', 80)."\n";
        fgets(\STDIN,10);
    }else{
        sleep($sleep);
    }
}

echo "\n\n****************************************************\n";
echo "All examples have run with no exceptions\n";
exit(0);
