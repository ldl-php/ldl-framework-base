<?php declare(strict_types=1);

namespace LDL\Framework\Helper;

use LDL\Framework\Base\Exception\InvalidArgumentException;

final class ReflectionHelper
{

    /**
     * Returns an array with all available classes in a PHP file
     * Slight modification of a stack overflow answer to accept multiple namespaces + classes
     *
     * Returns an array containing the namespace as they key and the defined classes as the items
     *
     * @TODO Add support for PHP 8 enums
     * @TODO There should be a way to avoid using in array for more performance
     *
     * @see https://stackoverflow.com/questions/7153000/get-class-name-from-file/44654073
     * @param string $file
     * @return array
     * @throws InvalidArgumentException
     */
    public static function fromFile(string $file) : array
    {
        $buffer = file_get_contents($file);

        if(false === $buffer){
            throw new InvalidArgumentException("Could not open file $file for reading");
        }

        $namespace = '';
        $i = 0;
        $return = [];

        if('' === $namespace){
            $namespace = '\\';
        }

        $tokens = token_get_all($buffer);

        for (;$i<count($tokens);$i++) {
            if ($tokens[$i][0] === T_NAMESPACE) {
                for ($j=$i+1;$j<count($tokens); $j++) {
                    if ($tokens[$j][0] === T_STRING) {
                        $namespace = $tokens[$j][1];
                        $return[$namespace] = [
                            'interface' => [],
                            'class' => [],
                            'trait' => []
                        ];
                    } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                        break;
                    }
                }
            }

            if (\T_CLASS ===  $tokens[$i][0]) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if (
                        $tokens[$j] === '{' &&
                        !in_array($tokens[$i+2][1], $return[$namespace]['class'], true)
                    ) {
                        $class = $tokens[$i+2][1];
                        $return[$namespace]['class'][] = $class;
                    }
                }
            }

            if (\T_INTERFACE === $tokens[$i][0]) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if (
                        $tokens[$j] === '{' &&
                        !in_array($tokens[$i+2][1], $return[$namespace]['interface'], true)
                    ) {
                        $return[$namespace]['interface'][] = $tokens[$i+2][1];
                    }
                }
            }

            if (\T_TRAIT === $tokens[$i][0]) {
                for ($j=$i+1;$j<count($tokens);$j++) {
                    if (
                        $tokens[$j] === '{' &&
                        !in_array($tokens[$i+2][1], $return[$namespace]['trait'], true)
                    ) {
                        $return[$namespace]['trait'][] = $tokens[$i+2][1];
                    }
                }
            }
        }

        foreach($return as $namespace => $class){
            if(count($return[$namespace]) === 0){
                unset($return[$namespace]);
            }
        }

        return $return;
    }

}
