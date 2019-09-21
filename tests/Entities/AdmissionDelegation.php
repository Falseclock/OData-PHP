<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
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
}
