<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Complex;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class Functionality extends Entity
{
	const SCHEME = "rights";
	const TABLE  = "functionalities";
	/**
	 * Идентификатор функционала, автоинкремент, первичный ключ
	 *
	 * @var int
	 * @see FunctionalityMap::id
	 */
	public $id;
	/**
	 * Название функционала
	 *
	 * @var string
	 * @see FunctionalityMap::$name
	 */
	public $name;
	/**
	 * Краткое описание функционала
	 *
	 * @var string
	 * @see FunctionalityMap::description
	 */
	public $description;
	/**
	 * Константа создана позже для того чтобы можно было дампить карту настроек и загружать ее из песочницы в продакшин
	 *
	 * @var string
	 * @see FunctionalityMap::constant
	 */
	public $constant;
	/**
	 *     *
	 * @var Permission[]
	 * @see FunctionalityMap::$Permissions
	 */
	public $Permissions;
}

class FunctionalityMap extends Mapper
{
	const ANNOTATION = "Описание функционалов площадки, как например: Авторизация, Регистрация, Торги, Аукционы, Избранное, и т.д. При разработке новых фич или разделов необходимо определить функционал общим словом. Далее для этого функционала в процессе разработки определяются разрешения и связываются через таблицу functionality_permissions. ";
	/**
	 * @var Column
	 * @see Functionality::$id
	 */
	public $id = [
		Column::NAME        => "functionality_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('functionalities_functionality_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор функционала, автоинкремент, первичный ключ",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Functionality::$name
	 */
	public $name = [
		Column::NAME        => "functionality_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 64,
		Column::ANNOTATION  => "Название функционала",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Functionality::$description
	 */
	public $description = [
		Column::NAME        => "functionality_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Краткое описание функционала",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Functionality::$constant
	 */
	public $constant = [
		Column::NAME        => "functionality_constant",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Константа создана позже для того чтобы можно было дампить карту настроек и загружать ее из песочницы в продакшин",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @see Functionality::$Permissions
	 * @var Complex
	 */
	protected $Permissions = [
		Complex::TYPE     => Permission::class,
		Complex::ITERABLE => true,
	];
}
