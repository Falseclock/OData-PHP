<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class Permission extends Entity
{
	const SCHEME = "rights";
	const TABLE  = "permissions";
	/**
	 * Идентификатор разрешения, уникальный, серийный.
	 *
	 * @var int
	 * @see PermissionMap::$id
	 */
	public $id;
	/**
	 * Название или константа разрешения, пишется заглавными буквами, в начале указывается сущность, затем действие. например: TENDER_CREATE.; При вставки или обновлении
	 * название триггером переводится в верхний регистр и удаляются пробелы в начале и в конце строки.
	 *
	 * @var string
	 * @see PermissionMap::$constant
	 */
	public $constant;
	/**
	 * Описание разрешения для вывода в подсказках
	 *
	 * @var string
	 * @see PermissionMap::$description
	 */
	public $description;
	/**
	 * TODO: временное поле, удалить после перехода на новую платформу.
	 *
	 * @var boolean
	 * @see PermissionMap::$isActive
	 */
	public $isActive;
	/**
	 * Это заголовок разрешения. По сути краткое описание разрешения
	 *
	 * @var string
	 * @see PermissionMap::$title
	 */
	public $title;
}

class PermissionMap extends Mapper
{
	const ANNOTATION = "При разработке сперва определяется функционал, а затем, по мере его разработки, настраиваются разрешения.; В данный момент обговорены следующие постфиксы в названиях разрешений:; 1. VIEW - просмотр
2. CREATE - создание
3. PUBLISH - публикация
4. UPDATE - обновление или изменение
5. DELETE - удаление данных
6. APPROVE - подтверждение; Функциональности не обязаны иметь все виды разрешений и могут иметь 1 или 2, например VIEW и CREATE.; Например мы создали функционал регистрации и подтверждения своих коллег на площадке в рамках компании. То есть администратор компании может подтвердить чью-то регистрацию или зарегистрировать вручную своих коллег. Соответственно при разработки логично будет сделать права:
1. EMPLOYEES_APPROVE - подтверждать самостоятельные регистрации;
2. EMPLOYEES_CREATE - создавать новых пользователей в своей компании.";
	/**
	 * @var Column
	 * @see Permission::$id
	 */
	public $id = [
		Column::NAME        => "permission_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('permissions_permission_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор разрешения, уникальный, серийный.",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Permission::$constant
	 */
	public $constant = [
		Column::NAME        => "permission_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 64,
		Column::ANNOTATION  => "Название или константа разрешения, пишется заглавными буквами, в начале указывается сущность, затем действие. например: TENDER_CREATE.; При вставки или обновлении название триггером переводится в верхний регистр и удаляются пробелы в начале и в конце строки.",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Permission::$description
	 */
	public $description = [
		Column::NAME        => "permission_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Описание разрешения для вывода в подсказках",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Permission::$isActive
	 */
	public $isActive = [
		Column::NAME        => "permission_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "TODO: временное поле, удалить после перехода на новую платформу.",
		Column::ORIGIN_TYPE => "bool"
	];
	/**
	 * @var Column
	 * @see Permission::$title
	 */
	public $title = [
		Column::NAME        => "permission_title",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Это заголовок разрешения. По сути краткое описание разрешения",
		Column::ORIGIN_TYPE => "varchar"
	];
}
