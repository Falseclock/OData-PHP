<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Constraint;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Join;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class TenderLot extends Entity
{
	const SCHEME = "tender";
	const TABLE  = "tender_lots";
	/**
	 * Номер тендерного лота, уникальный, серийный
	 *
	 * @var int
	 * @see TenderLotMap::id
	 */
	public $id;
	/**
	 * Наименовение лота
	 *
	 * @var string
	 * @see TenderLotMap::name
	 */
	public $name;
	/**
	 * Более расширенное описание лота
	 *
	 * @var string
	 * @see TenderLotMap::description
	 */
	public $description;
	/**
	 * Бюджет лота за единицу товара или услуги
	 *
	 * @var string
	 * @see TenderLotMap::budget
	 */
	public $budget;
	/**
	 * Количество поставляемых товаров или услуг
	 *
	 * @var string
	 * @see TenderLotMap::quantity
	 */
	public $quantity;
	/**
	 * Дата начала приема заявок по лоту
	 *
	 * @var string
	 * @see TenderLotMap::dateStart
	 */
	public $dateStart;
	/**
	 * Дата окончания приема заявок. Лот может автоматически продлятся и эта дата ответственна за это
	 *
	 * @var string
	 * @see TenderLotMap::dateStop
	 */
	public $dateStop;
	/**
	 * Полнотекстовый поиск по лоту; FIXME: изменить на not null после ввода новой страницы создания лота
	 *
	 * @var string
	 * @see TenderLotMap::fts
	 */
	public $fts;
	/**
	 * Статус достуности лота к публичному показу. По сути это статус удаления
	 *
	 * @var boolean
	 * @see TenderLotMap::isActive
	 */
	public $isActive;
	/**
	 * Комментарий к статусу лота. Обычно устанавливается, когда статус изменяется на невозможный к дальнейшему участию в лоте
	 *
	 * @var string
	 * @see TenderLotMap::stateExplanation
	 */
	public $stateExplanation;
	/**
	 * Ссылка на тип лота
	 *
	 * @var int
	 * @see TenderLotMap::typeId
	 */
	public $typeId;
	/**
	 * Ссылка на статус лота в тендерах
	 *
	 * @var int
	 * @see TenderLotMap::stateId
	 */
	public $stateId;
	/**
	 * Доступ к лоту
	 *
	 * @var boolean
	 * @see TenderLotMap::isPublic
	 */
	public $isPublic;
	/**
	 *
	 *
	 * @var string
	 * @see TenderLotMap::dateCommit
	 */
	public $dateCommit;
	/**
	 * Таблица видов состояний каждого лота тендера
	 *
	 * @var TenderLotState
	 * @see TenderLotMap::TenderLotState
	 */
	public $TenderLotState;
	/**
	 * Типы закупа в тендерных лотах
	 *
	 * @var TenderLotType[]
	 * @see TenderLotMap::TenderLotType
	 */
	public $TenderLotType;
	/**
	 * Таблица тендеров, которая аккумулирует в себя лоты
	 *
	 * @var Tender
	 * @see TenderLotMap::Tender
	 */
	public $Tender;
}

class TenderLotMap extends Mapper
{
	const ANNOTATION = "Таблица лотов, которые принадлежат определенному тендеру.; Вниание на опции тендера. Через coalesce проверяется есть ли кастомная опция для лота, затем проверяется настройка для компании и потом только берется стандартная настройка";
	/** @see TenderLot::id */
	public $id = [
		Column::NAME        => "tender_lot_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('auctions_auctionid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Номер тендерного лота, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/** @see TenderLot::name */
	public $name = [
		Column::NAME        => "tender_lot_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 512,
		Column::ANNOTATION  => "Наименовение лота",
		Column::ORIGIN_TYPE => "varchar"
	];
	/** @see TenderLot::description */
	public $description = [
		Column::NAME        => "tender_lot_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Более расширенное описание лота",
		Column::ORIGIN_TYPE => "text"
	];
	/** @see TenderLot::budget */
	public $budget = [
		Column::NAME        => "tender_lot_budget",
		Column::TYPE        => Primitive::Decimal,
		Column::DEFAULT     => "0",
		Column::NULLABLE    => false,
		Column::SCALE       => 5,
		Column::PRECISION   => 30,
		Column::ANNOTATION  => "Бюджет лота за единицу товара или услуги",
		Column::ORIGIN_TYPE => "numeric"
	];
	/** @see TenderLot::quantity */
	public $quantity = [
		Column::NAME        => "tender_lot_quantity",
		Column::TYPE        => Primitive::Decimal,
		Column::DEFAULT     => "0",
		Column::NULLABLE    => false,
		Column::SCALE       => 5,
		Column::PRECISION   => 22,
		Column::ANNOTATION  => "Количество поставляемых товаров или услуг",
		Column::ORIGIN_TYPE => "numeric"
	];
	/** @see TenderLot::dateStart */
	public $dateStart = [
		Column::NAME        => "tender_lot_date_start",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::DEFAULT     => "now()",
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ANNOTATION  => "Дата начала приема заявок по лоту",
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/** @see TenderLot::dateStop */
	public $dateStop = [
		Column::NAME        => "tender_lot_date_stop",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ANNOTATION  => "Дата окончания приема заявок. Лот может автоматически продлятся и эта дата ответственна за это",
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/** @see TenderLot::fts */
	public $fts = [
		Column::NAME        => "tender_lot_fts",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Полнотекстовый поиск по лоту; FIXME: изменить на not null после ввода новой страницы создания лота",
		Column::ORIGIN_TYPE => "tsvector"
	];
	/** @see TenderLot::isActive */
	public $isActive = [
		Column::NAME        => "tender_lot_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Статус достуности лота к публичному показу. По сути это статус удаления",
		Column::ORIGIN_TYPE => "bool"
	];
	/** @see TenderLot::stateExplanation */
	public $stateExplanation = [
		Column::NAME        => "tender_lot_state_explanation",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Комментарий к статусу лота. Обычно устанавливается, когда статус изменяется на невозможный к дальнейшему участию в лоте",
		Column::ORIGIN_TYPE => "text"
	];
	/** @see TenderLot::typeId */
	public $typeId = [
		Column::NAME        => "tender_lot_type_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на тип лота",
		Column::ORIGIN_TYPE => "int4"
	];
	/** @see TenderLot::stateId */
	public $stateId = [
		Column::NAME        => "tender_lot_state_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на статус лота в тендерах",
		Column::ORIGIN_TYPE => "int4"
	];
	/** @see TenderLot::isPublic */
	public $isPublic = [
		Column::NAME        => "tender_lot_is_public",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Доступ к лоту",
		Column::ORIGIN_TYPE => "bool"
	];
	/** @see TenderLot::dateCommit */
	public $dateCommit = [
		Column::NAME        => "tender_lot_date_commit",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/** @see TenderLot::TenderLotState */
	protected $TenderLotState = [
		Constraint::COLUMN         => "tender_lot_state_id",
		Constraint::FOREIGN_SCHEME => "tender",
		Constraint::FOREIGN_TABLE  => "tender_lot_states",
		Constraint::FOREIGN_COLUMN => "tender_lot_state_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE
	];
	/** @see TenderLot::TenderLotType */
	protected $TenderLotType = [
		Constraint::COLUMN         => "tender_lot_type_id",
		Constraint::FOREIGN_SCHEME => "tender",
		Constraint::FOREIGN_TABLE  => "tender_lot_types",
		Constraint::FOREIGN_COLUMN => "tender_lot_type_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE
	];
	/** @see TenderLot::Tender */
	protected $Tender = [
		Constraint::COLUMN         => "tender_id",
		Constraint::FOREIGN_SCHEME => "tender",
		Constraint::FOREIGN_TABLE  => "tenders_new",
		Constraint::FOREIGN_COLUMN => "tender_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE
	];
}
