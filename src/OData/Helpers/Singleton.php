<?php
/**
 * Класс Singleton
 *
 * @package      Base
 * @copyright    2004-2007 by Sveta A. Smirnova
 * @license      GNU (Library|Lesser) General Public License, version 3
 */

namespace Falseclock\OData\Helpers;

use Exception;

abstract class Singleton implements Instantiatable
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
	 * Функция возвращает массив всех инстанцированных классов
	 *
	 * @return array
	 */
	final public static function getAllInstances() {
		return self::$instances;
	}

	/**
	 * @return mixed|Singleton|static
	 * @throws Exception
	 */
	public static function me() {
		return self::getInstance(get_called_class());
	}

	/**
	 * Функция получения инстанса класса
	 *
	 * @param string $class
	 * @param null   $args
	 *
	 * @return mixed|Singleton
	 * @throws Exception
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
	 * Функция клонирования классов и их объектов запрещена
	 */
	final private function __clone() {/* do not clone me */
	}
}