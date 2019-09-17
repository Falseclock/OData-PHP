<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
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
}

class TenderMap extends Mapper
{
	const ANNOTATION = "Таблица тендеров, которая аккумулирует в себя лоты";
	/** @see Tender::id */
	public $id = [
		Column::NAME        => "tender_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('tenders_tenderid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор тендера, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/** @see Tender::datePublication */
	public $datePublication = [
		Column::NAME        => "tender_date_publication",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ANNOTATION  => "Дата опубликования тендера. Не путать с датой начало торгов. Публикация может быть раньше, чем начинается торговля",
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/** @see Tender::isActive */
	public $isActive = [
		Column::NAME        => "tender_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ORIGIN_TYPE => "bool"
	];
}
