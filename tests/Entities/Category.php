<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Entity;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class Category extends Entity
{
	const SCHEME = "handbook";
	const TABLE  = "categories";
	/**
	 * Идентификатор категории, уникальный, серийный
	 *
	 * @var int
	 * @see CategoryMap::id
	 */
	public $id;
	/**
	 * Название категории
	 *
	 * @var string
	 * @see CategoryMap::$name
	 */
	public $name;
	/**
	 * Дополнительная информация по категории
	 *
	 * @var string
	 * @see CategoryMap::description
	 */
	public $description;
	/**
	 * Ссылка на родительскую категорию
	 *
	 * @var int
	 * @see CategoryMap::parentId
	 */
	public $parentId;
	/**
	 * Статус доступности категории
	 *
	 * @var boolean
	 * @see CategoryMap::isActive
	 */
	public $isActive;
	/**
	 * Кастомное поле из вьюшек
	 *
	 * @var mixed
	 * @see CategoryMap::$anyField
	 */
	public $anyField;
}

class CategoryMap extends Mapper
{
	const ANNOTATION = "Категоризация лотов";
	/**
	 * @var Column
	 * @see Category::$id
	 */
	public $id = [
		Column::NAME        => "category_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('categories_category_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор категории, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Category::$name
	 */
	public $name = [
		Column::NAME        => "category_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Название категории",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Category::$description
	 */
	public $description = [
		Column::NAME        => "category_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 512,
		Column::ANNOTATION  => "Дополнительная информация по категории",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Category::$parentId
	 */
	public $parentId = [
		Column::NAME        => "category_parent_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на родительскую категорию",
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Category::$isActive
	 */
	public $isActive = [
		Column::NAME        => "category_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Статус доступности категории",
		Column::ORIGIN_TYPE => "bool"
	];
	/**
	 * @var Column
	 * @see Category::$anyField
	 */
	public $anyField = [
		Column::NAME        => "category_any_field",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => true,
		Column::ANNOTATION  => "Кастомное поле из вьюшек",
		Column::ORIGIN_TYPE => "unknown"
	];
}
