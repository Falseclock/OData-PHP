<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Complex;
use Falseclock\DBD\Entity\Constraint;
use Falseclock\DBD\Entity\Embedded;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Join;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;
use Falseclock\DBD\Entity\Type;

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
	 * @see TenderLotMap::$name
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
	 * @see TenderLotMap::$budgetPerItem
	 */
	public $budgetPerItem;
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
	 * @see TenderLotMap::$fullTextSearch
	 */
	public $fullTextSearch;
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
	 * Таблица валют
	 *
	 * @var Currency
	 * @see TenderLotMap::$Currency
	 */
	public $Currency;
	/**
	 * Категоризация лотов
	 *
	 * @var Category
	 * @see TenderLotMap::$Category
	 */
	public $Category;
	/**
	 * Территориальные единицы доставки или поставки
	 *
	 * @var DeliveryEntity
	 * @see TenderLotMap::$DeliveryEntity
	 */
	public $DeliveryEntity;
	/**
	 * Единицы измерения, используемые в лотах, аукционах, планах и т.д.
	 *
	 * @var MeasureUnit
	 * @see TenderLotMap::$MeasureUnit
	 */
	public $MeasureUnit;
	/**
	 * Таблица видов состояний каждого лота тендера
	 *
	 * @var TenderLotState
	 * @see TenderLotMap::$TenderLotState
	 */
	public $TenderLotState;
	/**
	 * Типы закупа в тендерных лотах
	 *
	 * @var TenderLotType
	 * @see TenderLotMap::$TenderLotType
	 */
	public $TenderLotType;
	/**
	 * Таблица тендеров, которая аккумулирует в себя лоты
	 *
	 * @var Tender
	 * @see TenderLotMap::$Tender
	 */
	public $Tender;
	/**
	 * Специальное поле, когда нам надо что-то посчитать или от куда-то взять
	 *
	 * @var mixed $anyField
	 * @see TenderLotMap::$anyField
	 */
	public $anyField;
	/**
	 * Количество ставок в лоте, считается из вьюшки
	 *
	 * @var integer $bidsCount
	 * @see TenderLotMap::$bidsCount
	 */
	public $bidsCount;
	/**
	 * Общий объем лота
	 *
	 * @var float $volume общий объем лота
	 * @see TenderLotMap::$volume
	 */
	public $volume;
	/**
	 * Кастомное представление, берется из вьюшки
	 *
	 * @var InitiatorUser
	 * @see TenderLotMap::$InitiatorUser
	 */
	public $InitiatorUser;
	/**
	 * Кастомное представление, берется из вьюшки
	 *
	 * @var InitiatorPerson
	 * @see TenderLotMap::$InitiatorPerson
	 */
	public $InitiatorPerson;
	/**
	 * Кастомное представление, берется из вьюшки
	 *
	 * @var InitiatorCompany
	 * @see TenderLotMap::$InitiatorCompany
	 */
	public $InitiatorCompany;
}

class TenderLotMap extends Mapper
{
	const ANNOTATION = "Таблица лотов, которые принадлежат определенному тендеру.; Вниание на опции тендера. Через coalesce проверяется есть ли кастомная опция для лота, затем проверяется настройка для компании и потом только берется стандартная настройка";
	/**
	 * @var Column
	 * @see TenderLot::$id
	 */
	public $id = [
		Column::NAME        => "tender_lot_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('auctions_auctionid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Номер тендерного лота, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see TenderLot::$name
	 */
	public $name = [
		Column::NAME        => "tender_lot_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 512,
		Column::ANNOTATION  => "Наименовение лота",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see TenderLot::$description
	 */
	public $description = [
		Column::NAME        => "tender_lot_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Более расширенное описание лота",
		Column::ORIGIN_TYPE => "text"
	];
	/**
	 * @var Column
	 * @see TenderLot::$budgetPerItem
	 */
	public $budgetPerItem = [
		Column::NAME        => "tender_lot_budget",
		Column::TYPE        => Primitive::Decimal,
		Column::DEFAULT     => "0",
		Column::NULLABLE    => false,
		Column::SCALE       => 5,
		Column::PRECISION   => 30,
		Column::ANNOTATION  => "Бюджет лота за единицу товара или услуги",
		Column::ORIGIN_TYPE => "numeric"
	];
	/**
	 * @var Column
	 * @see TenderLot::$quantity
	 */
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
	/**
	 * @var Column
	 * @see TenderLot::$dateStart
	 */
	public $dateStart = [
		Column::NAME        => "tender_lot_date_start",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::DEFAULT     => "now()",
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ANNOTATION  => "Дата начала приема заявок по лоту",
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/**
	 * @var Column
	 * @see TenderLot::$dateStop
	 */
	public $dateStop = [
		Column::NAME        => "tender_lot_date_stop",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ANNOTATION  => "Дата окончания приема заявок. Лот может автоматически продлятся и эта дата ответственна за это",
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/**
	 * @var Column
	 * @see TenderLot::$fullTextSearch
	 */
	public $fullTextSearch = [
		Column::NAME        => "tender_lot_fts",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Полнотекстовый поиск по лоту; FIXME: изменить на not null после ввода новой страницы создания лота",
		Column::ORIGIN_TYPE => "tsvector"
	];
	/**
	 * @var Column
	 * @see TenderLot::$isActive
	 */
	public $isActive = [
		Column::NAME        => "tender_lot_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Статус достуности лота к публичному показу. По сути это статус удаления",
		Column::ORIGIN_TYPE => "bool"
	];
	/**
	 * @var Column
	 * @see TenderLot::$stateExplanation
	 */
	public $stateExplanation = [
		Column::NAME        => "tender_lot_state_explanation",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Комментарий к статусу лота. Обычно устанавливается, когда статус изменяется на невозможный к дальнейшему участию в лоте",
		Column::ORIGIN_TYPE => "text"
	];
	/**
	 * @var Column
	 * @see TenderLot::$isPublic
	 */
	public $isPublic = [
		Column::NAME        => "tender_lot_is_public",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Доступ к лоту",
		Column::ORIGIN_TYPE => "bool"
	];
	/**
	 * @var Column
	 * @see TenderLot::$dateCommit
	 */
	public $dateCommit = [
		Column::NAME        => "tender_lot_date_commit",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/**
	 * @var Embedded
	 * @see TenderLot::$anyField
	 */
	public $anyField = [
		Embedded::NAME    => "tender_lot_any_field",
		Embedded::DB_TYPE => Type::Varchar,
	];
	/**
	 * @var Embedded
	 * @see TenderLot::$bidsCount
	 */
	public $bidsCount = [
		Embedded::NAME    => "tender_lot_bids_count",
		Embedded::DB_TYPE => Type::BigInt,
	];
	/**
	 * @var Embedded
	 * @see TenderLot::$volume
	 */
	public    $volume  = [
		Embedded::NAME    => "tender_lot_volume",
		Embedded::DB_TYPE => Type::Double,
	];
	protected $typeId  = [
		Column::NAME        => "tender_lot_type_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на тип лота",
		Column::ORIGIN_TYPE => "int4"
	];
	protected $stateId = [
		Column::NAME        => "tender_lot_state_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на статус лота в тендерах",
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @see TenderLot::$Currency
	 * @see TenderLotMap::$currencyId
	 * @var Constraint
	 */
	protected $Currency = [
		Constraint::LOCAL_COLUMN   => "currency_id",
		Constraint::FOREIGN_SCHEME => "handbook",
		Constraint::FOREIGN_TABLE  => "currencies",
		Constraint::FOREIGN_COLUMN => "currency_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => Currency::class
	];
	/**
	 * @see TenderLot::$Category
	 * @see TenderLotMap::$categoryId
	 * @var Constraint
	 */
	protected $Category = [
		Constraint::LOCAL_COLUMN   => "category_id",
		Constraint::FOREIGN_SCHEME => "handbook",
		Constraint::FOREIGN_TABLE  => "categories",
		Constraint::FOREIGN_COLUMN => "category_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => Category::class
	];
	/**
	 * @see TenderLot::$DeliveryEntity
	 * @see TenderLotMap::$deliveryEntityId
	 * @var Constraint
	 */
	protected $DeliveryEntity = [
		Constraint::LOCAL_COLUMN   => "delivery_entity_id",
		Constraint::FOREIGN_SCHEME => "handbook",
		Constraint::FOREIGN_TABLE  => "delivery_entities",
		Constraint::FOREIGN_COLUMN => "delivery_entity_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => DeliveryEntity::class
	];
	/**
	 * @see TenderLot::$MeasureUnit
	 * @see TenderLotMap::$measureUnitId
	 * @var Constraint
	 */
	protected $MeasureUnit = [
		Constraint::LOCAL_COLUMN   => "measure_unit_id",
		Constraint::FOREIGN_SCHEME => "handbook",
		Constraint::FOREIGN_TABLE  => "measure_units",
		Constraint::FOREIGN_COLUMN => "measure_unit_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => MeasureUnit::class
	];
	/**
	 * @see TenderLot::$TenderLotState
	 * @see TenderLotMap::$stateId
	 * @var Constraint
	 */
	protected $TenderLotState = [
		Constraint::LOCAL_COLUMN   => "tender_lot_state_id",
		Constraint::FOREIGN_SCHEME => "tender",
		Constraint::FOREIGN_TABLE  => "tender_lot_states",
		Constraint::FOREIGN_COLUMN => "tender_lot_state_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => TenderLotState::class
	];
	/**
	 * @see TenderLot::$TenderLotType
	 * @see TenderLotMap::$typeId
	 * @var Constraint
	 */
	protected $TenderLotType = [
		Constraint::LOCAL_COLUMN   => "tender_lot_type_id",
		Constraint::FOREIGN_SCHEME => "tender",
		Constraint::FOREIGN_TABLE  => "tender_lot_types",
		Constraint::FOREIGN_COLUMN => "tender_lot_type_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => TenderLotType::class
	];
	/**
	 * @see TenderLot::$Tender
	 * @see TenderLotMap::$tenderId
	 * @var Constraint
	 */
	protected $Tender           = [
		Constraint::LOCAL_COLUMN   => "tender_id",
		Constraint::FOREIGN_SCHEME => "tender",
		Constraint::FOREIGN_TABLE  => "tenders_new",
		Constraint::FOREIGN_COLUMN => "tender_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => Tender::class
	];
	protected $tenderId         = [
		Column::NAME        => "tender_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на тендер, под которым открывали лот",
		Column::ORIGIN_TYPE => "int4"
	];
	protected $deliveryEntityId = [
		Column::NAME        => "delivery_entity_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на регион поставки конкретного лота",
		Column::ORIGIN_TYPE => "int4"
	];
	protected $categoryId       = [
		Column::NAME        => "category_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на категорию в которой открыт лот.",
		Column::ORIGIN_TYPE => "int4"
	];
	protected $currencyId       = [
		Column::NAME        => "currency_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на валюту",
		Column::ORIGIN_TYPE => "int4"
	];
	protected $measureUnitId    = [
		Column::NAME        => "measure_unit_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на единицу измерения",
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @see TenderLot::$InitiatorUser
	 * @var Complex
	 */
	protected $InitiatorUser = [
		Complex::TYPE => InitiatorUser::class,
	];
	/**
	 * @see TenderLot::$InitiatorPerson
	 * @var Complex
	 */
	protected $InitiatorPerson = [
		Complex::TYPE => InitiatorPerson::class,
	];
	/**
	 * @see TenderLot::$InitiatorCompany
	 * @var Complex
	 */
	protected $InitiatorCompany = [
		Complex::TYPE => InitiatorCompany::class,
	];
}
