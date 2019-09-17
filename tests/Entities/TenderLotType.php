<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class TenderLotType extends Entity
{
	const SCHEME = "tender";
	const TABLE  = "tender_lot_types";
	/**
	 * Идентификатор типа тендера, уникальный, серийный
	 *
	 * @var int
	 * @see TenderLotTypeMap::id
	 */
	public $id;
	/**
	 * Наименование типа тендера
	 *
	 * @var string
	 * @see TenderLotTypeMap::name
	 */
	public $name;
	/**
	 * Описание типа торга в лота
	 *
	 * @var string
	 * @see TenderLotTypeMap::description
	 */
	public $description;
	/**
	 * Константа типа тендерного лота
	 *
	 * @var string
	 * @see TenderLotTypeMap::constant
	 */
	public $constant;
}

class TenderLotTypeMap extends Mapper
{
	const ANNOTATION = "Типы закупа в тендерных лотах";
	/** @see TenderLotType::id */
	public $id = [
		Column::NAME        => "tender_lot_type_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('tender_lot_types_tender_lot_type_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор типа тендера, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/** @see TenderLotType::name */
	public $name = [
		Column::NAME        => "tender_lot_type_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 64,
		Column::ANNOTATION  => "Наименование типа тендера",
		Column::ORIGIN_TYPE => "varchar"
	];
	/** @see TenderLotType::description */
	public $description = [
		Column::NAME        => "tender_lot_type_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 512,
		Column::ANNOTATION  => "Описание типа торга в лота",
		Column::ORIGIN_TYPE => "varchar"
	];
	/** @see TenderLotType::constant */
	public $constant = [
		Column::NAME        => "tender_lot_type_constant",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Константа типа тендерного лота",
		Column::ORIGIN_TYPE => "varchar"
	];
}