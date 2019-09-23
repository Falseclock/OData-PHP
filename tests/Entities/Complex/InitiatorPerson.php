<?php

namespace Tests\Entities\Complex;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Interfaces\Row;
use Falseclock\DBD\Entity\Primitive;
use Tests\Entities\Person;
use Tests\Entities\PersonMap;

class InitiatorPerson extends Person implements Row
{
}

class InitiatorPersonMap extends PersonMap
{
	/**
	 * @var Column
	 * @see Person::$firstName
	 */
	public $firstName = [
		Column::NAME        => "initiator_user_first_name",
		Column::TYPE        => Primitive::String,
		Column::DEFAULT     => "''::character varying",
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Реальное имя пользователя.; TODO: может быть NULL.; TODO: убрать дефолтное значение; TODO: сконвертить дефисы в null",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Person::$lastName
	 */
	public $lastName = [
		Column::NAME        => "initiator_user_last_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Фамилия пользователя. Может быть NULL; TODO: изменить дефолтное значение",
		Column::ORIGIN_TYPE => "varchar"
	];
}
