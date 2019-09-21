<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class LegalForm extends Entity
{
	const FORM_AOO                 = "AAO_OWNERSHIP"; // FIXME: кривая аббревиатура
	const FORM_CORPORATE           = "CORPORATE_FOUNDATION";
	const FORM_INDIVIDUAL          = "INDIVIDUAL_OWNERSHIP";
	const FORM_JCS                 = "JCS_OWNERSHIP";
	const FORM_LLC                 = "LLC_OWNERSHIP";
	const FORM_OOO                 = "ООО_OWNERSHIP"; // FIXME: в базе русскими буквами
	const FORM_OTHER               = "OTHER_OWNERSHIP";
	const FORM_PK                  = "PK_OWNERSHIP";
	const FORM_PRIVATE_INSTITUTION = "PRIVATE_INSTITUTION";
	const FORM_PUBLIC_ASSOCIATION  = "PUBLIC_ASSOCIATION";
	const FORM_ZAO                 = "ZAO_OWNERSHIP";
	const SCHEME                   = "handbook";
	const TABLE                    = "legal_forms";
	/**
	 *
	 *
	 * @var int
	 * @see LegalFormMap::id
	 */
	public $id;
	/**
	 *
	 *
	 * @var string
	 * @see LegalFormMap::abbreviation
	 */
	public $abbreviation;
	/**
	 *
	 *
	 * @var string
	 * @see LegalFormMap::description
	 */
	public $description;
	/**
	 *
	 *
	 * @var string
	 * @see LegalFormMap::constant
	 */
	public $constant;
}

class LegalFormMap extends Mapper
{
	const ANNOTATION = "";
	/**
	 * @var Column
	 * @see LegalForm::$id
	 */
	public $id = [
		Column::NAME        => "legal_form_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('legal_forms_legal_form_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see LegalForm::$abbreviation
	 */
	public $abbreviation = [
		Column::NAME        => "legal_form_value",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see LegalForm::$description
	 */
	public $description = [
		Column::NAME        => "legal_form_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 1024,
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see LegalForm::$constant
	 */
	public $constant = [
		Column::NAME        => "legal_form_constant",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 128,
		Column::ORIGIN_TYPE => "varchar"
	];
}
