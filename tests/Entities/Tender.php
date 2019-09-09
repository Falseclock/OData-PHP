<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class Tender extends Entity
{
	const TABLE = "tender.tenders_new";
	public $id;
	public $name;
	public $datePublication;
	public $isActive;
	/** @var User $User */
	public $User;
	/** @var TenderLot[] $TenderLots */
	public    $TenderLots;
	protected $json    = [];
	protected $objects = [
		'TenderLots' => TenderLot::class,
		'User'       => User::class
	];
}

class TenderMap extends Mapper
{
	public $id              = [ Column::NAME => "tender_id", Column::TYPE => Primitive::Int32, Column::NULLABLE => false ];
	public $name            = [ Column::NAME => "tender_name", Column::TYPE => Primitive::String, Column::NULLABLE => false, Column::MAXLENGTH => 1024 ];
	public $datePublication = [ Column::NAME => "tender_date_publication", Column::TYPE => Primitive::DateTimeOffset, Column::NULLABLE => false ];
	public $isActive        = [ Column::NAME => "tender_is_active", Column::TYPE => Primitive::Boolean, Column::NULLABLE => false, Column::DEFAULT => true ];
}

