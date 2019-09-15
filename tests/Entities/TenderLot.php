<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class TenderLot extends Entity
{
	const SCHEME = "tender";
	const TABLE  = "tender_lots";
	/** @var int $id Номер тендерного лота, уникальный, серийный */
	public $id;
	/** @var string $name Наименовение лота */
	public $name;
	/** @var string $description Более расширенное описание лота */
	public $description;
	/** @var string $budget Бюджет лота за единицу товара или услуги */
	public $budget;
	/** @var string $quantity Количество поставляемых товаров или услуг */
	public $quantity;
	/** @var string $dateStart Дата начала приема заявок по лоту */
	public $dateStart;
	/** @var string $dateStop Дата окончания приема заявок. Лот может автоматически продлятся и эта дата ответственна за это */
	public $dateStop;
	/** @var string $fts Полнотекстовый поиск по лоту; FIXME: изменить на not null после ввода новой страницы создания лота */
	public $fts;
	/** @var boolean $isActive Статус достуности лота к публичному показу. По сути это статус удаления */
	public $isActive;
	/** @var string $stateExplanation Комментарий к статусу лота. Обычно устанавливается, когда статус изменяется на невозможный к дальнейшему участию в лоте */
	public $stateExplanation;
	/** @var int $typeId Ссылка на тип лота */
	public $typeId;
	/** @var int $stateId Ссылка на статус лота в тендерах */
	public $stateId;
	/** @var boolean $isPublic Доступ к лоту */
	public $isPublic;
	/** @var string $dateCommit */
	public $dateCommit;
}

class TenderLotMap extends Mapper
{
	public $id               = [
		Column::NAME       => "tender_lot_id",
		Column::TYPE       => Primitive::Int32,
		Column::DEFAULT    => "nextval('auctions_auctionid_seq'::regclass)",
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Номер тендерного лота, уникальный, серийный",
		Column::KEY        => true
	];
	public $name             = [
		Column::NAME       => "tender_lot_name",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::MAXLENGTH  => 512,
		Column::ANNOTATION => "Наименовение лота"
	];
	public $description      = [
		Column::NAME       => "tender_lot_description",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Более расширенное описание лота"
	];
	public $budget           = [
		Column::NAME       => "tender_lot_budget",
		Column::TYPE       => Primitive::Decimal,
		Column::DEFAULT    => "0",
		Column::NULLABLE   => false,
		Column::SCALE      => 5,
		Column::PRECISION  => 30,
		Column::ANNOTATION => "Бюджет лота за единицу товара или услуги"
	];
	public $quantity         = [
		Column::NAME       => "tender_lot_quantity",
		Column::TYPE       => Primitive::Decimal,
		Column::DEFAULT    => "0",
		Column::NULLABLE   => false,
		Column::SCALE      => 5,
		Column::PRECISION  => 22,
		Column::ANNOTATION => "Количество поставляемых товаров или услуг"
	];
	public $dateStart        = [
		Column::NAME       => "tender_lot_date_start",
		Column::TYPE       => Primitive::DateTimeOffset,
		Column::DEFAULT    => "now()",
		Column::NULLABLE   => false,
		Column::PRECISION  => 6,
		Column::ANNOTATION => "Дата начала приема заявок по лоту"
	];
	public $dateStop         = [
		Column::NAME       => "tender_lot_date_stop",
		Column::TYPE       => Primitive::DateTimeOffset,
		Column::NULLABLE   => false,
		Column::PRECISION  => 6,
		Column::ANNOTATION => "Дата окончания приема заявок. Лот может автоматически продлятся и эта дата ответственна за это"
	];
	public $fts              = [
		Column::NAME       => "tender_lot_fts",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Полнотекстовый поиск по лоту; FIXME: изменить на not null после ввода новой страницы создания лота"
	];
	public $isActive         = [
		Column::NAME       => "tender_lot_is_active",
		Column::TYPE       => Primitive::Boolean,
		Column::DEFAULT    => "true",
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Статус достуности лота к публичному показу. По сути это статус удаления"
	];
	public $stateExplanation = [
		Column::NAME       => "tender_lot_state_explanation",
		Column::TYPE       => Primitive::String,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Комментарий к статусу лота. Обычно устанавливается, когда статус изменяется на невозможный к дальнейшему участию в лоте"
	];
	public $typeId           = [
		Column::NAME       => "tender_lot_type_id",
		Column::TYPE       => Primitive::Int32,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Ссылка на тип лота"
	];
	public $stateId          = [
		Column::NAME       => "tender_lot_state_id",
		Column::TYPE       => Primitive::Int32,
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Ссылка на статус лота в тендерах"
	];
	public $isPublic         = [
		Column::NAME       => "tender_lot_is_public",
		Column::TYPE       => Primitive::Boolean,
		Column::DEFAULT    => "true",
		Column::NULLABLE   => false,
		Column::ANNOTATION => "Доступ к лоту"
	];
	public $dateCommit       = [ Column::NAME => "tender_lot_date_commit", Column::TYPE => Primitive::DateTimeOffset, Column::NULLABLE => false, Column::PRECISION => 6 ];
}