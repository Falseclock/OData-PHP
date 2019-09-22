<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Constraint;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Join;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;

class AdmissionDelegation extends Entity
{
	const SCHEME = "rights";
	const TABLE  = "admission_delegation";
	/**
	 * Ссылка на доступ, который может быть делигирован для определенного доступа
	 *
	 * @var int
	 * @see AdmissionDelegationMap::$delegation
	 */
	public $delegation;
	/**
	 * Таблица доступа к площадке. Здесь определяются названия видов доступа к площадке, допустим:; 1. Гость; 2. Поисковая машина; 3. Новый пользователь без компании; 4.
	 * Компания на пробном тарифе; 5. Компания на платном тарифе; 6. Народный банк; 7. Air Astana
	 *
	 * @var Admission
	 * @see PersonMap::$Admission
	 */
	public $Admission;
}

class AdmissionDelegationMap extends Mapper
{
	const ANNOTATION = "Список уровней доступа, который аккаунт может делигировать другим пользователям.
Например SUPERVISER может давать уровень доступа GUEST, REGULAR, OPERATOR.
ADMIN может давать доступ любого уровня.
OPERATOR может, допустим, регистрировать пользователя дав права REGULAR";
	/**
	 * @var Column
	 * @see AdmissionDelegation::$delegation
	 */
	public $delegation = [
		Column::NAME        => "admission_id_delegation",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на доступ, который может быть делигирован для определенного доступа",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * Ссылка на admissions. Поле позволяет задать разрешения и права для тех, кто зарегистрировался но не указал свою компанию
	 *
	 * @var Column
	 */
	protected $admissionId = [
		Column::NAME        => "admission_id",
		Column::TYPE        => Primitive::Int32,
		Column::ORIGIN_TYPE => "int4",
		Column::KEY         => true,
		Column::NULLABLE    => false,
	];
	/**
	 * @see Person::$Admission
	 * @see PersonMap::$admissionId
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
}
