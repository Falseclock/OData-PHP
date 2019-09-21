<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Primitive;

class InitiatorCompany extends Company
{
}

class InitiatorCompanyMap extends CompanyMap
{
	const ANNOTATION = "Для лотов, чтобы можно было разделять на создателей и участников";
	/**
	 * @var Column
	 * @see Company::$name
	 */
	public $name = [
		Column::NAME        => "initiator_company_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 255,
		Column::ANNOTATION  => "Название компании согласно ГБДЮЛ без аббревиатуры организационной формы",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Company::$id
	 */
	public $id = [
		Column::NAME        => "company_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('comp_general_compid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
}
