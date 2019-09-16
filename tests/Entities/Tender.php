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
	/** @var int $id Идентификатор тендера, уникальный, серийный */
	public $id;
	/** @var string $datePublication Дата опубликования тендера. Не путать с датой начало торгов. Публикация может быть раньше, чем начинается торговля */
	public $datePublication;
	/** @var string $oldData */
	public $oldData;
	/** @var boolean $isActive */
	public $isActive;
}

class TenderMap extends Mapper
{
	const ANNOTATION = "Таблица тендеров, которая аккумулирует в себя лоты";
	public $id              = [
		Column::NAME       => "tender_id",
		Column::TYPE       => Primitive::Int32,
		Column::DEFAULT    => "nextval('tenders_tenderid_seq'::regclass)",
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Идентификатор тендера, уникальный, серийный",
		Column::KEY        => true
	];
	public $datePublication = [ Column::NAME       => "tender_date_publication",
								Column::TYPE       => Primitive::DateTimeOffset,
								Column::NULLABLE   => false,
								Column::PRECISION  => 6,
								Column::ANNOTATION => "Дата опубликования тендера. Не путать с датой начало торгов. Публикация может быть раньше, чем начинается торговля"
	];
	public $oldData         = [ Column::NAME => "tender_old_data", Column::TYPE => Primitive::String, Column::NULLABLE => false ];
	public $isActive        = [ Column::NAME => "tender_is_active", Column::TYPE => Primitive::Boolean, Column::DEFAULT => "true", Column::NULLABLE => false ];
}