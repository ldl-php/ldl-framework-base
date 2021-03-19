<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use LDL\Framework\Base\Exception\Combined\CombinedException;
use LDL\Framework\Base\Collection\Exception\LockAppendException;
use LDL\Framework\Base\Collection\Exception\LockRemoveException;
use LDL\Framework\Base\Exception\Combined\CombinedExceptionInterface;

echo "Create collection\n";

$collection = new CombinedException();

echo "Append RunTimeException\n";

$collection->append(new \RuntimeException("This is a RunTimeException"));

echo "Append InvalidArgumentException\n";

$collection->append(new \InvalidArgumentException("This is an InvalidArgumentException"));

echo "Append Many: Exception, LogicException\n";

$collection->appendMany([
    new \Exception("Generic Exception"),
    new \LogicException("This is a LogicException")
]);

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    $class = get_class($value);
    echo "Key: $key, Item: $class\n";
}

try{
    echo "Try to add a string, exception must be thrown\n";
    $collection->append('string');
}catch(\LogicException $e){
    echo "EXCEPTION: {$e->getMessage()}\n";
}

try{
    echo "Try to add an stdClass object item, exception must be thrown\n";
    $collection->append(new \stdClass());
}catch(\LogicException $e){
    echo "EXCEPTION: {$e->getMessage()}\n";
}

echo "Lock append\n";

$collection->lockAppend();

try{
    echo "Try to add another item, exception must be thrown\n";
    $collection->append(new \Exception());
}catch(LockAppendException $e){
    echo "EXCEPTION: {$e->getMessage()}\n";
}

echo "Remove item with key 1\n";

$collection->remove(1);

echo "Remove last item\n";

$collection->removeLast();

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    $class = get_class($value);
    echo "Key: $key, Item: $class\n";
}

echo "Lock remove\n";

$collection->lockRemove();

try{
    echo "Try to remove an item, exception must be thrown\n";
    $collection->removeLast();
}catch(LockRemoveException $e){
    echo "EXCEPTION: {$e->getMessage()}\n";
}

echo "Check items in the collection\n";

/**
 * @var \Exception $value
 */
foreach($collection as $key => $value){
    $class = get_class($value);
    echo "Key: $key, Item: $class\n";
}


echo "Throw combined exception, catch it and show the combined message\n";

try{
    throw $collection;
}catch(CombinedExceptionInterface $e){
    echo $e->getCombinedMessage()."\n";
}
