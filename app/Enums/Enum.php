<?php

namespace App\Enums;

use ReflectionClass;

/*
| Uma Classe que faz a mágica dos enumeradores funcionar
*/

abstract class Enum
{
    private static $constCacheArray = NULL;

    private static function getConstants()
    {
        if (self::$constCacheArray == NULL) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if (!array_key_exists($calledClass, self::$constCacheArray)) {
            $reflect = new ReflectionClass($calledClass);
            self::$constCacheArray[$calledClass] = $reflect->getConstants();
        }
        return self::$constCacheArray[$calledClass];
    }

    //Verifica se um nome é válido
    public static function isValidName($name, $strict = false)
    {
        $constants = self::getConstants();

        if ($strict) {
            return array_key_exists($name, $constants);
        }

        $keys = array_map('strtolower', array_keys($constants));
        return in_array(strtolower($name), $keys);
    }

    //Verifica se um Valor é válido
    public static function isValidValue($value, $strict = true)
    {
        $values = array_values(self::getConstants());
        return in_array($value, $values, $strict);
    }

    //Retorna todos os nomes como array Valor => Chave
    public static function asArray()
    {
        return array_flip(self::getConstants());
    }

    //Retorna o nome de um valor
    public static function getName($value)
    {
        return array_search($value, self::getConstants());
    }
}
