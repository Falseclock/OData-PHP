<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Entity;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class CompanyData extends Entity
{
	const SCHEME = "membership";
	const TABLE  = "companies_data";
	/**
	 * Расчетный счет в банке
	 *
	 * @var string
	 * @see CompanyDataMap::$bankAccountNumber
	 */
	public $bankAccountNumber;
	/**
	 * БИК банка
	 *
	 * @var string
	 * @see CompanyDataMap::$bankIdentityCode
	 */
	public $bankIdentityCode;
	/**
	 * Сделано чтобы работала старая таблица comp_requisite. TODO: избавиться после перехода
	 *
	 * @var int
	 * @see CompanyDataMap::$id
	 */
	public $id;
}

class CompanyDataMap extends Mapper
{
	const ANNOTATION = "Сопутствующие данные компании";
	/**
	 * @var Column
	 * @see CompanyData::$bankAccountNumber
	 */
	public $bankAccountNumber = [
		Column::NAME        => "company_data_account_info",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Расчетный счет в банке",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see CompanyData::$bankIdentityCode
	 */
	public $bankIdentityCode = [
		Column::NAME        => "company_data_bic",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 50,
		Column::ANNOTATION  => "БИК банка",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see CompanyData::$id
	 */
	public $id = [
		Column::NAME        => "company_data_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('comp_requisite_requsiteid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Сделано чтобы работала старая таблица comp_requisite. TODO: избавиться после перехода",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Company::$id
	 */
	public $companyId = [
		Column::NAME        => "company_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('comp_general_compid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
}
