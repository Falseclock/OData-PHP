<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class TenderLots extends Entity
{
	const SCHEME = "tender";
	const TABLE  = "tender_lots";
	/**
	 * Номер тендерного лота, уникальный, серийный
	 *
	 * @var int
	 * @see TenderLotsMap::$id
	 */
	public $id;
	/**
	 * Наименовение лота
	 *
	 * @var string
	 * @see TenderLotsMap::$name
	 */
	public $name;
	/**
	 * Более расширенное описание лота
	 *
	 * @var string
	 * @see TenderLotsMap::$description
	 */
	public $description;
	/**
	 * Бюджет лота за единицу товара или услуги
	 *
	 * @var string
	 * @see TenderLotsMap::$budget
	 */
	public $budget;
	/**
	 * Количество поставляемых товаров или услуг
	 *
	 * @var string
	 * @see TenderLotsMap::$quantity
	 */
	public $quantity;
	/**
	 * Дата начала приема заявок по лоту
	 *
	 * @var string
	 * @see TenderLotsMap::$dateStart
	 */
	public $dateStart;
	/**
	 * Дата окончания приема заявок. Лот может автоматически продлятся и эта дата ответственна за это
	 *
	 * @var string
	 * @see TenderLotsMap::$dateStop
	 */
	public $dateStop;
	/**
	 * Полнотекстовый поиск по лоту; FIXME: изменить на not null после ввода новой страницы создания лота
	 *
	 * @var string
	 * @see TenderLotsMap::$fts
	 */
	public $fts;
	/**
	 * Статус достуности лота к публичному показу. По сути это статус удаления
	 *
	 * @var boolean
	 * @see TenderLotsMap::$isActive
	 */
	public $isActive;
	/**
	 * Комментарий к статусу лота. Обычно устанавливается, когда статус изменяется на невозможный к дальнейшему участию в лоте
	 *
	 * @var string
	 * @see TenderLotsMap::$stateExplanation
	 */
	public $stateExplanation;
	/**
	 * Ссылка на тип лота
	 *
	 * @var int
	 * @see TenderLotsMap::$typeId
	 */
	public $typeId;
	/**
	 * Ссылка на статус лота в тендерах
	 *
	 * @var int
	 * @see TenderLotsMap::$stateId
	 */
	public $stateId;
	/**
	 * Доступ к лоту
	 *
	 * @var boolean
	 * @see TenderLotsMap::$isPublic
	 */
	public $isPublic;
	/**
	 *
	 *
	 * @var string
	 * @see TenderLotsMap::$dateCommit
	 */
	public $dateCommit;
	/** @var TenderLotStates $TenderLotStates Таблица видов состояний каждого лота тендера */
	public $TenderLotStates;
	/** @var TenderLotTypes $TenderLotTypes Типы закупа в тендерных лотах */
	public $TenderLotTypes;
	/** @var TendersNew $TendersNew Таблица тендеров, которая аккумулирует в себя лоты */
	public $TendersNew;
}

class TenderLotsMap extends Mapper
{
	const ANNOTATION = "Таблица лотов, которые принадлежат определенному тендеру.; Вниание на опции тендера. Через coalesce проверяется есть ли кастомная опция для лота, затем проверяется настройка для компании и потом только берется стандартная настройка";
	/** @see TenderLots::id */
	public $id = [
		Column::NAME       => "tender_lot_id",
		Column::TYPE       => Primitive::Int32,
		Column::DEFAULT    => "nextval('auctions_auctionid_seq'::regclass)",
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Номер тендерного лота, уникальный, серийный",
		Column::KEY        => true
	];
	/** @see TenderLots::name */
	public $name = [
		Column::NAME       => "tender_lot_name",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::MAXLENGTH  => 512,
		Column::ANNOTATION => "Наименовение лота"
	];
	/** @see TenderLots::description */
	public $description = [
		Column::NAME       => "tender_lot_description",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Более расширенное описание лота"
	];
	/** @see TenderLots::budget */
	public $budget = [
		Column::NAME       => "tender_lot_budget",
		Column::TYPE       => Primitive::Decimal,
		Column::DEFAULT    => "0",
		Column::NULLABLE   => false,
		Column::SCALE      => 5,
		Column::PRECISION  => 30,
		Column::ANNOTATION => "Бюджет лота за единицу товара или услуги"
	];
	/** @see TenderLots::quantity */
	public $quantity = [
		Column::NAME       => "tender_lot_quantity",
		Column::TYPE       => Primitive::Decimal,
		Column::DEFAULT    => "0",
		Column::NULLABLE   => false,
		Column::SCALE      => 5,
		Column::PRECISION  => 22,
		Column::ANNOTATION => "Количество поставляемых товаров или услуг"
	];
	/** @see TenderLots::dateStart */
	public $dateStart = [
		Column::NAME       => "tender_lot_date_start",
		Column::TYPE       => Primitive::DateTimeOffset,
		Column::DEFAULT    => "now()",
		Column::NULLABLE   => false,
		Column::PRECISION  => 6,
		Column::ANNOTATION => "Дата начала приема заявок по лоту"
	];
	/** @see TenderLots::dateStop */
	public $dateStop = [
		Column::NAME       => "tender_lot_date_stop",
		Column::TYPE       => Primitive::DateTimeOffset,
		Column::NULLABLE   => false,
		Column::PRECISION  => 6,
		Column::ANNOTATION => "Дата окончания приема заявок. Лот может автоматически продлятся и эта дата ответственна за это"
	];
	/** @see TenderLots::fts */
	public $fts = [
		Column::NAME       => "tender_lot_fts",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Полнотекстовый поиск по лоту; FIXME: изменить на not null после ввода новой страницы создания лота"
	];
	/** @see TenderLots::isActive */
	public $isActive = [
		Column::NAME       => "tender_lot_is_active",
		Column::TYPE       => Primitive::Boolean,
		Column::DEFAULT    => "true",
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Статус достуности лота к публичному показу. По сути это статус удаления"
	];
	/** @see TenderLots::stateExplanation */
	public $stateExplanation = [
		Column::NAME       => "tender_lot_state_explanation",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Комментарий к статусу лота. Обычно устанавливается, когда статус изменяется на невозможный к дальнейшему участию в лоте"
	];
	/** @see TenderLots::typeId */
	public $typeId = [ Column::NAME => "tender_lot_type_id", Column::TYPE => Primitive::Int32, Column::NULLABLE => false, Column::ANNOTATION => "Ссылка на тип лота" ];
	/** @see TenderLots::stateId */
	public $stateId = [
		Column::NAME       => "tender_lot_state_id",
		Column::TYPE       => Primitive::Int32,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Ссылка на статус лота в тендерах"
	];
	/** @see TenderLots::isPublic */
	public $isPublic = [
		Column::NAME       => "tender_lot_is_public",
		Column::TYPE       => Primitive::Boolean,
		Column::DEFAULT    => "true",
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Доступ к лоту"
	];
	/** @see TenderLots::dateCommit */
	public $dateCommit = [ Column::NAME => "tender_lot_date_commit", Column::TYPE => Primitive::DateTimeOffset, Column::NULLABLE => false, Column::PRECISION => 6 ];
}
