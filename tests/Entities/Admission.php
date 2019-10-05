<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Entity;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class Admission extends Entity
{
	const SCHEME = "rights";
	const TABLE  = "admissions";
	/**
	 *
	 *
	 * @var int
	 * @see AdmissionMap::id
	 */
	public $id;
	/**
	 * Название уровня доступа
	 *
	 * @var string
	 * @see AdmissionMap::$name
	 */
	public $name;
	/**
	 * Описание уровня доступа
	 *
	 * @var string
	 * @see AdmissionMap::description
	 */
	public $description;
	/**
	 * Константа доступа для определения в коде уровней доступа при различных состояних сессии
	 *
	 * @var string
	 * @see AdmissionMap::constant
	 */
	public $constant;
	/**
	 * Уровень логирования пользователя. Можно создать отдельный уровень доступа или присвоить пользователю уровень, чтобы включить для него отладку. В интерфейсе
	 * создать путем копирования существуюшего и затем настроить отладку.
	 *
	 * @var string
	 * @see AdmissionMap::logLevel
	 */
	public $logLevel;
	public $functionalitiesCount;
	public $companiesCount;
	public $personsCount;
	public $usageCount;
	/** @var Functionality[] $functionalities */
	public $Functionalities = [];
	/** @var Permission[] $Exclusions */
	public $Exclusions = [];
	/** @var AdmissionDelegation[] $Delegations */
	public $Delegations = [];
}

class AdmissionMap extends Mapper
{
	const ANNOTATION = "Таблица доступа к площадке. Здесь определяются названия видов доступа к площадке, допустим:; 1. Гость
2. Поисковая машина
3. Новый пользователь без компании
4. Компания на пробном тарифе
5. Компания на платном тарифе
6. Народный банк
7. Air Astana";
	/**
	 * @var Column
	 * @see Admission::$id
	 */
	public $id = [
		Column::NAME        => "admission_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('admissions_admission_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Admission::$name
	 */
	public $name = [
		Column::NAME        => "admission_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Название уровня доступа",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Admission::$description
	 */
	public $description = [
		Column::NAME        => "admission_description",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Описание уровня доступа",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Admission::$constant
	 */
	public $constant = [
		Column::NAME        => "admission_constant",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Константа доступа для определения в коде уровней доступа при различных состояних сессии",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Admission::$logLevel
	 */
	public $logLevel = [
		Column::NAME        => "admission_log_level",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 8,
		Column::ANNOTATION  => "Уровень логирования пользователя. Можно создать отдельный уровень доступа или присвоить пользователю уровень, чтобы включить для него отладку. В интерфейсе создать путем копирования существуюшего и затем настроить отладку.",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Admission::$functionalitiesCount
	 */
	public $functionalitiesCount = [
		Column::NAME => "admission_functionalities_count",
	];
	/**
	 * @var Column
	 * @see Admission::$companiesCount
	 */
	public $companiesCount = [
		Column::NAME => "admission_companies_count",
	];
	/**
	 * @var Column
	 * @see Admission::$personsCount
	 */
	public $personsCount = [
		Column::NAME => "admission_persons_count",
	];
	/**
	 * @var Column
	 * @see Admission::$usageCount
	 */
	public $usageCount = [
		Column::NAME => "admission_usage_count",
	];
	/** @var Column $functionalities */
	public $Functionalities = [
		Column::NAME        => "admission_functionalities",
		Column::ORIGIN_TYPE => "json",
	];
	/** @var Column $Exclusions */
	public $Exclusions = [
		Column::NAME        => "admission_exclusions",
		Column::ORIGIN_TYPE => "json",
	];
	/** @var Column $Delegations */
	public $Delegations = [
		Column::NAME        => "admission_delegations",
		Column::ORIGIN_TYPE => "json",
	];
}
