<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Entity;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class DeliveryEntity extends Entity
{
	const SCHEME = "handbook";
	const TABLE  = "delivery_entities";
	/**
	 * Идентификатор территориальной единицы, уникальный, серийный
	 *
	 * @var int
	 * @see DeliveryEntityMap::id
	 */
	public $id;
	/**
	 * Название территориальной единицы
	 *
	 * @var string
	 * @see DeliveryEntityMap::$name
	 */
	public $name;
	/**
	 * Полное наименование территориальной единицы доставки
	 *
	 * @var string
	 * @see DeliveryEntityMap::fullName
	 */
	public $fullName;
}

class DeliveryEntityMap extends Mapper
{
	const ANNOTATION = "Территориальные единицы доставки или поставки";
	/**
	 * @var Column
	 * @see DeliveryEntity::$id
	 */
	public $id = [
		Column::NAME        => "delivery_entity_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('delivery_entities_delivery_entity_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор территориальной единицы, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see DeliveryEntity::$name
	 */
	public $name = [
		Column::NAME        => "delivery_entity_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 128,
		Column::ANNOTATION  => "Название территориальной единицы",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see DeliveryEntity::$fullName
	 */
	public $fullName = [
		Column::NAME        => "delivery_entity_full_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 512,
		Column::ANNOTATION  => "Полное наименование территориальной единицы доставки",
		Column::ORIGIN_TYPE => "varchar"
	];
}
