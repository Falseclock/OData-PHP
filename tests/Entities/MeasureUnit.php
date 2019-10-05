<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Entity;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class MeasureUnit extends Entity
{
	const SCHEME = "handbook";
	const TABLE  = "measure_units";
	/**
	 * Идентификатор единицы измерения, уникальный, серийный
	 *
	 * @var int
	 * @see MeasureUnitMap::id
	 */
	public $id;
	/**
	 * Полное название единицы измерения
	 *
	 * @var string
	 * @see MeasureUnitMap::$name
	 */
	public $name;
}

class MeasureUnitMap extends Mapper
{
	const ANNOTATION = "Единицы измерения, используемые в лотах, аукционах, планах и т.д.";
	/**
	 * @var Column
	 * @see MeasureUnit::$id
	 */
	public $id = [
		Column::NAME        => "measure_unit_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('measure_units_measure_unit_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор единицы измерения, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see MeasureUnit::$name
	 */
	public $name = [
		Column::NAME        => "measure_unit_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 64,
		Column::ANNOTATION  => "Полное название единицы измерения",
		Column::ORIGIN_TYPE => "varchar"
	];
}
