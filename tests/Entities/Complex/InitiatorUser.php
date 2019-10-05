<?php

namespace Tests\Entities\Complex;

use DBD\Entity\Column;
use DBD\Entity\Interfaces\Row;
use DBD\Entity\Primitive;
use Tests\Entities\User;
use Tests\Entities\UserMap;

class InitiatorUser extends User implements Row
{
}

class InitiatorUserMap extends UserMap
{
	const ANNOTATION = "Специально для лотов";
	/**
	 * @var Column
	 * @see User::$id
	 */
	public $id = [
		Column::NAME        => "initiator_user_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('users_user_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор записи, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
}