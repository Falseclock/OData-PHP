<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class TenderLotState extends Entity
{
	const SCHEME = "tender";
	const TABLE  = "tender_lot_states";
	/**
	 * Идентификатор статуса лота, уникальный, серийный
	 *
	 * @var int
	 * @see TenderLotStateMap::id
	 */
	public $id;
	/**
	 * Название статуса лота тендера
	 *
	 * @var string
	 * @see TenderLotStateMap::name
	 */
	public $name;
	/**
	 * Описание статус лота тендера
	 *
	 * @var string
	 * @see TenderLotStateMap::description
	 */
	public $description;
	/**
	 * Константа тендерного лота
	 *
	 * @var string
	 * @see TenderLotStateMap::constant
	 */
	public $constant;
}

class TenderLotStateMap extends Mapper
{
	const ANNOTATION = "Таблица видов состояний каждого лота тендера";
	/** @see TenderLotState::id */
	public $id = [
		Column::NAME        => "tender_lot_state_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('tender_lot_states_tender_lot_state_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор статуса лота, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/** @see TenderLotState::name */
	public $name = [
		Column::NAME        => "tender_lot_state_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 64,
		Column::ANNOTATION  => "Название статуса лота тендера",
		Column::ORIGIN_TYPE => "varchar"
	];
	/** @see TenderLotState::description */
	public $description = [
		Column::NAME        => "tender_lot_state_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 512,
		Column::ANNOTATION  => "Описание статус лота тендера",
		Column::ORIGIN_TYPE => "varchar"
	];
	/** @see TenderLotState::constant */
	public $constant = [
		Column::NAME        => "tender_lot_state_constant",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Константа тендерного лота",
		Column::ORIGIN_TYPE => "varchar"
	];
}
