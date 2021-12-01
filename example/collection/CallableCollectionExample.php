<?php declare(strict_types=1);

use LDL\Framework\Base\Collection\CallableCollection;
use LDL\Framework\Base\Constants;

require __DIR__.'/../../vendor/autoload.php';

echo "Sorting logic has been separately written in SortHelper, we can change the sort logic as per case. Since php sorting functions in PHP < 8.0 were unstable. The sorting order has been reversed from php 8. please check the rfc: https://wiki.php.net/rfc/stable_sorting\n";

$i = "param";

 echo "\nAppend callable actions in CallableCollection\n";

 $callableCollection = new CallableCollection();

 $callableCollection->appendMany([
   static function($i){ echo "1st Callable\n"; },
   static function($i){ echo "2nd Callable\n"; },
   "a" => static function($i){ echo "4th Callable\n"; },
   2 => static function($i){ echo "3rd Callable\n"; }
], true);

 echo var_export(iterator_to_array($callableCollection), true) . "\n";

 echo "\nExecute callables in ascending order\n";

 $callableCollection->callSorted(Constants::SORT_ASCENDING, $i);

 echo "\nExecute callables in descending order\n";

 $callableCollection->callSorted(Constants::SORT_DESCENDING, $i);


