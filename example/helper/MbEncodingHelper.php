<?php declare(strict_types=1);

require __DIR__.'/../../vendor/autoload.php';

use LDL\Framework\Helper\MbEncodingHelper;

echo "UTF-8 is valid?\n";
echo MbEncodingHelper::isValid('UTF-8') ? 'Yes' : 'No';

try{
    echo "\n\nValidate non-existent encoding UTF-22\n";
    MbEncodingHelper::validate('UTF-22');
}catch(\InvalidArgumentException $e){
    echo $e->getMessage()."\n";
}


