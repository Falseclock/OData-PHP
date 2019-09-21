<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class TenderLotState extends Entity
{
	/**
	 * ВНИМАНИЕ! После измнениея, удалением или добавления нового статуса, необходимо
	 * 1. перебилдить индекс tender_lot_search_any_public_state
	 * 2. изменить триггерную функцию tender.tender_lot_search_any_public_state() в таблице tender_lots
	 * 3. проверить логику установки статусов лотов при поиске @see TenderLotsSearch::setLotState()
	 */
	const CANCELED      = "CANCELED";
	const DEAL_CANCELED = "DEAL_CANCELED";
	const FINISHED      = "FINISHED";
	const ON_APPROVAL   = "ON_APPROVAL";
	const ON_DRAFT      = "ON_DRAFT";
	const ON_MODERATION = "ON_MODERATION";
	const ON_NEXT_STEP  = "ON_NEXT_STEP";
	const OPEN_FOR_BID  = "OPEN_FOR_BID";
	const PUBLISHED     = "PUBLISHED";
	const SCHEME        = "tender";
	const SUCCESSFUL    = "SUCCESSFUL";
	const TABLE         = "tender_lot_states";
	const UNSUCCESSFUL  = "UNSUCCESSFUL";
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
	 * @see TenderLotStateMap::$name
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
	/**
	 * @var Column
	 * @see TenderLotState::$id
	 */
	public $id = [
		Column::NAME        => "tender_lot_state_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('tender_lot_states_tender_lot_state_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор статуса лота, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see TenderLotState::$name
	 */
	public $name = [
		Column::NAME        => "tender_lot_state_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 64,
		Column::ANNOTATION  => "Название статуса лота тендера",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see TenderLotState::$description
	 */
	public $description = [
		Column::NAME        => "tender_lot_state_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 512,
		Column::ANNOTATION  => "Описание статус лота тендера",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see TenderLotState::$constant
	 */
	public $constant = [
		Column::NAME        => "tender_lot_state_constant",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Константа тендерного лота",
		Column::ORIGIN_TYPE => "varchar"
	];
}
