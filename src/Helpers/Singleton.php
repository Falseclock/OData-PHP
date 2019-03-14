<?php
/**
 * <description should be written here>
 *
 * @package      OData\Server\Helpers
 * @copyright    Copyright © 2004-2007 by Sveta A. Smirnova
 * @license      GNU (Library|Lesser) General Public License, version 3
 */

namespace OData\Server\Helpers;

use Exception;

trait Singleton
{
    /**
     * Все вызванные ранее инстансы классов
     *
     * @var array $instances
     */
    private static $instances = [];

    /**
     * Singleton constructor.
     */
    protected function __construct() {/* you can't create me */
    }

    /**
     * Функция получения инстанса класса
     *
     * @param string $class
     * @param null   $args
     *
     * @return mixed|Singleton
     * @throws \Exception
     */
    final public static function getInstance($class, $args = null /* , ... */) {
        // for Singleton::getInstance('class_name', $arg1, ...) calling
        if(2 < func_num_args()) {
            $args = func_get_args();
            array_shift($args);
        }

        if(!isset(self::$instances[$class])) {
            $object = $args ? new $class($args) : new $class;

            if(!($object instanceof Singleton)) {
                throw new Exception("Class '{$class}' is something not a Singleton's child");
            }

            return self::$instances[$class] = $object;
        }
        else {
            return self::$instances[$class];
        }
    }

    /**
     * Функция возвращает массив всех инстанцированных классов
     *
     * @return array
     */
    final public static function getAllInstances() {
        return self::$instances;
    }

    /**
     * Функция клонирования классов и их объектов запрещена
     */
    final private function __clone() {/* do not clone me */
    }
}