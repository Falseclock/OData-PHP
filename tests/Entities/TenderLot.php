<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class TenderLot extends Entity
{
	const TABLE = "tender.tender_lots";
	/** @var int $id */
	public $id;
	/** @var string $name */
	public $name;
	public $quantity;
	/** @var float $budgetPerItem цена за единицу товара или услуги */
	public $budgetPerItem;
	/** @var string $dateStart дата начала приема заявок на лот */
	public $dateStart;
	/** @var string $dateStop дата окончания приема ставок на лот */
	public $dateStop;
	/** @var string $dateCommit */
	public $dateCommit;
	/** @var float $volume общий объем лота */
	public $volume;
	/** @var mixed $anyField специальное поле, когда нам надо что-то посчитать или от куда-то взять */
	public $anyField;
	/** @var integer $bidsCount */
	public $bidsCount;
	/** @var string $fullTextSearch */
	public $fullTextSearch;
	/** @var boolean $isActive */
	public $isActive;
	/** @var boolean $isPublic */
	public $isPublic;
	/** @var Currency $Currency */
	public $Currency;
	/** @var Category $Category */
	public $Category;
	/** @var InitiatorCompany $InitiatorCompany */
	public $InitiatorCompany;
	/** @var InitiatorUser $InitiatorUser */
	public $InitiatorUser;
	/** @var DeliveryEntity $DeliveryEntity */
	public $DeliveryEntity;
	/** @var TenderLotType $TenderLotType */
	public $TenderLotType;
	/** @var TenderLotState $LotState */
	public $LotState;
	/** @var Tender $Tender */
	public $Tender;
	/** @var MeasureUnit $MeasureUnit единица измерения */
	public    $MeasureUnit;
	protected $json    = [];
	protected $objects = [
		'Currency'         => Currency::class,
		'Category'         => Category::class,
		'InitiatorCompany' => InitiatorCompany::class,
		'InitiatorUser'    => InitiatorUser::class,
		'DeliveryEntity'   => DeliveryEntity::class,
		'TenderLotType'    => TenderLotType::class,
		'LotState'         => TenderLotState::class,
		'Tender'           => Tender::class,
		'MeasureUnit'      => MeasureUnit::class
	];
}

class TenderLotMap extends Mapper
{
	public $id       = [ Column::NAME => "tender_lot_id", Column::TYPE => Primitive::Int32, Column::NULLABLE => false ];
	public $name     = [ Column::NAME => "tender_lot_name", Column::TYPE => Primitive::String, Column::NULLABLE => false, Column::MAXLENGTH => 512 ];
	public $quantity = [
		Column::NAME      => "tender_lot_quantity",
		Column::TYPE      => Primitive::Decimal,
		Column::NULLABLE  => false,
		Column::SCALE     => 22,
		Column::PRECISION => 5,
	];
	/*	public $description            = "tender_lot_description";
		public $budgetPerItem          = "tender_lot_budget";
		public $dateStart              = "tender_lot_date_start";
		public $dateStop               = "tender_lot_date_stop";
		public $dateCommit             = "tender_lot_date_commit";
		public $volume                 = "tender_lot_volume";
		public $anyField               = "tender_lot_any_field";
		public $bidsCount              = "tender_lot_bids_count";
		public $fullTextSearch         = "tender_lot_fts";
		public $isActive               = "tender_lot_is_active";
		public $stateExplanation       = "tender_lot_state_explanation";
		public $contractorRequirements = "tender_lot_contractor_requirements";
		public $paymentOptions         = "tender_lot_payment_options";
		public $deliveryTime           = "tender_lot_delivery_time";
		public $isPublic               = "tender_lot_is_public";*/
}

