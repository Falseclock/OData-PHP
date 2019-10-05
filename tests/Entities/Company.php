<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Constraint;
use DBD\Entity\Entity;
use DBD\Entity\Join;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class Company extends Entity
{
	const SCHEME = "membership";
	const TABLE  = "companies";
	/**
	 *
	 *
	 * @var int
	 * @see CompanyMap::$id
	 */
	public $id;
	/**
	 * Название компании согласно ГБДЮЛ без аббревиатуры организационной формы
	 *
	 * @var string
	 * @see CompanyMap::$name
	 */
	public $name;
	/**
	 * Дата регистрации на площадке
	 *
	 * @var string
	 * @see CompanyMap::$registrationDate
	 */
	public $registrationDate;
	/**
	 * По сути статус удаления. Если стоит FALSE то компания не имеет доступа к площадке и не отображается в веб интерфейсе
	 *
	 * @var boolean
	 * @see CompanyMap::$isActive
	 */
	public $isActive;
	/**
	 * БИН / ИИН компании
	 *
	 * @var string
	 * @see CompanyMap::$identity
	 */
	public $identity;
	/**
	 * Таблица доступа к площадке. Здесь определяются названия видов доступа к площадке, допустим:; 1. Гость; 2. Поисковая машина; 3. Новый пользователь без компании; 4.
	 * Компания на пробном тарифе; 5. Компания на платном тарифе; 6. Народный банк; 7. Air Astana
	 *
	 * @var Admission
	 * @see CompanyMap::$Admission
	 */
	public $Admission;
	/**
	 *
	 *
	 * @var LegalForm
	 * @see CompanyMap::$LegalForm
	 */
	public $LegalForm;
	/**
	 *
	 *
	 * @var CompanyData
	 * @see CompanyMap::$CompanyData
	 */
	public $CompanyData;
}

class CompanyMap extends Mapper
{
	const ANNOTATION = "Основная таблица компаний. Храним только название и уникальный идентификатор БИН/ИИН. Все остальные данные вынесены в отдельную таблицу.";
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
	/**
	 * @var Column
	 * @see Company::$name
	 */
	public $name = [
		Column::NAME        => "company_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 255,
		Column::ANNOTATION  => "Название компании согласно ГБДЮЛ без аббревиатуры организационной формы",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Company::$registrationDate
	 */
	public $registrationDate = [
		Column::NAME        => "company_registration_date",
		Column::TYPE        => Primitive::DateTimeOffset,
		Column::DEFAULT     => "now()",
		Column::NULLABLE    => false,
		Column::PRECISION   => 6,
		Column::ANNOTATION  => "Дата регистрации на площадке",
		Column::ORIGIN_TYPE => "timestamptz"
	];
	/**
	 * @var Column
	 * @see Company::$isActive
	 */
	public $isActive = [
		Column::NAME        => "company_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "По сути статус удаления. Если стоит FALSE то компания не имеет доступа к площадке и не отображается в веб интерфейсе",
		Column::ORIGIN_TYPE => "bool"
	];
	/**
	 * @var Column
	 * @see Company::$identity
	 */
	public $identity    = [
		Column::NAME        => "company_identity",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 50,
		Column::ANNOTATION  => "БИН / ИИН компании",
		Column::ORIGIN_TYPE => "varchar"
	];
	public $admissionId = [
		Column::NAME        => "admission_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('admissions_admission_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see LegalForm::$id
	 */
	public $legalFormId = [
		Column::NAME        => "legal_form_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('legal_forms_legal_form_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @see Company::$Admission
	 * @var Constraint
	 */
	protected $Admission = [
		Constraint::LOCAL_COLUMN   => "admission_id",
		Constraint::FOREIGN_SCHEME => "rights",
		Constraint::FOREIGN_TABLE  => "admissions",
		Constraint::FOREIGN_COLUMN => "admission_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => Admission::class
	];
	/**
	 * @see Company::$LegalForm
	 * @var Constraint
	 */
	protected $LegalForm = [
		Constraint::LOCAL_COLUMN   => "legal_form_id",
		Constraint::FOREIGN_SCHEME => "handbook",
		Constraint::FOREIGN_TABLE  => "legal_forms",
		Constraint::FOREIGN_COLUMN => "legal_form_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => LegalForm::class
	];
	/**
	 * @see Company::$CompanyData
	 * @var Constraint
	 */
	protected $CompanyData = [
		Constraint::LOCAL_COLUMN   => "company_id",
		Constraint::FOREIGN_SCHEME => "membership",
		Constraint::FOREIGN_TABLE  => "companies_data",
		Constraint::FOREIGN_COLUMN => "company_id",
		Constraint::JOIN_TYPE      => Join::ONE_TO_ONE,
		Constraint::BASE_CLASS     => CompanyData::class
	];
}
