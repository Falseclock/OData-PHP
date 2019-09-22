<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Complex;
use Falseclock\DBD\Entity\Constraint;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Join;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class Tender extends Entity
{
	const SCHEME = "tender";
	const TABLE  = "tenders_new";
	/**
	 * Идентификатор тендера, уникальный, серийный
	 *
	 * @var int
	 * @see TenderMap::id
	 */
	public $id;
	/**
	 * Дата опубликования тендера. Не путать с датой начало торгов. Публикация может быть раньше, чем начинается торговля
	 *
	 * @var string
	 * @see TenderMap::datePublication
	 */
	public $datePublication;
	/**
	 *
	 *
	 * @var boolean
	 * @see TenderMap::isActive
	 */
	public $isActive;
	/**
	 * Название тендера, берется из вьюшки
	 *
	 * @var string
	 * @see TenderMap::$name
	 */
	public $name;
	/**
	 * Таблица связки персоналий с компаниями через эту таблицу. То есть 1 пользователь может быть участником нескольких компаний.
	 *
	 * @var User
	 * @see TenderMap::$User
	 */
	public $User;
	/**
	 * @var TenderLot[]
	 * @see TenderMap::$TenderLots
	 */
	public $TenderLots;
}

class TenderMap extends Mapper
{
	const ANNOTATION = "Таблица тендеров, которая аккумулирует в себя лоты";
	/**
	 * @var Column
	 * @see Tender::$id
	 */
	public $id = [
		Column::NAME        => "tender_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('tenders_tenderid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор тендера, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Tender::$datePublication
	 */
	public $datePublication = [
		Column::NAME        => "tender_date_publication",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ANNOTATION  => "Дата опубликования тендера. Не путать с датой начало торгов. Публикация может быть раньше, чем начинается торговля",
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/**
	 * @var Column
	 * @see Tender::$isActive
	 */
	public $isActive = [
		Column::NAME        => "tender_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ORIGIN_TYPE => "bool"
	];
	/**
	 * @var Column
	 * @see Tender::$name
	 */
	public $name = [
		Column::NAME        => "tender_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 1024,
		Column::ANNOTATION  => "Берется из вьюшки",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @see Tender::$User
	 * @var Constraint
	 */
	protected $User = [
		Constraint::LOCAL_COLUMN   => "user_id",
		Constraint::FOREIGN_SCHEME => "membership",
		Constraint::FOREIGN_TABLE  => "users",
		Constraint::FOREIGN_COLUMN => "user_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => User::class
	];
	/**
	 * @see Tender::$TenderLots
	 * @var Complex
	 */
	protected $TenderLots = [
		Complex::TYPE     => TenderLot::class,
		Complex::ITERABLE => true,
	];
	protected $userId     = [
		Column::NAME        => "user_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на сотрудника компании, которая открывает тендер или лоты",
		Column::ORIGIN_TYPE => "int4"
	];
}
