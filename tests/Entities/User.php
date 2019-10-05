<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Constraint;
use DBD\Entity\Entity;
use DBD\Entity\Join;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class User extends Entity
{
	const SCHEME = "membership";
	const TABLE  = "users";
	/**
	 * Идентификатор записи, уникальный, серийный
	 *
	 * @var int
	 * @see UserMap::id
	 */
	public $id;
	/**
	 * Должность пользователя в компании
	 *
	 * @var string
	 * @see UserMap::title
	 */
	public $title;
	/**
	 * Основная таблица компаний. Храним только название и уникальный идентификатор БИН/ИИН. Все остальные данные вынесены в отдельную таблицу.
	 *
	 * @var Company
	 * @see UserMap::$InitiatorCompany
	 */
	public $Company;
	/**
	 * Таблица регистрации пользователей. Содержит уникальные регистрации.
	 *
	 * @var Person
	 * @see UserMap::$Person
	 */
	public $Person;
}

class UserMap extends Mapper
{
	const ANNOTATION = "Таблица связки персоналий с компаниями через эту таблицу. То есть 1 пользователь может быть участником нескольких компаний.";
	/**
	 * @var Column
	 * @see User::$id
	 */
	public $id = [
		Column::NAME        => "user_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('users_user_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор записи, уникальный, серийный",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see User::$title
	 */
	public    $title     = [
		Column::NAME        => "user_title",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Должность пользователя в компании",
		Column::ORIGIN_TYPE => "varchar"
	];
	protected $companyId = [
		Column::NAME        => "company_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на компанию. TODO: вернуть NOT NULL как только перейдем на новую регистрацию",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @see User::$Company
	 * @var Constraint
	 */
	protected $Company = [
		Constraint::LOCAL_COLUMN   => "company_id",
		Constraint::FOREIGN_SCHEME => "membership",
		Constraint::FOREIGN_TABLE  => "companies",
		Constraint::FOREIGN_COLUMN => "company_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => Company::class
	];
	/**
	 * @see User::$Person
	 * @var Constraint
	 */
	protected $Person   = [
		Constraint::LOCAL_COLUMN   => "person_id",
		Constraint::FOREIGN_SCHEME => "membership",
		Constraint::FOREIGN_TABLE  => "persons",
		Constraint::FOREIGN_COLUMN => "person_id",
		Constraint::JOIN_TYPE      => Join::MANY_TO_ONE,
		Constraint::BASE_CLASS     => Person::class
	];
	protected $personId = [
		Column::NAME        => "person_id",
		Column::TYPE        => Primitive::Int32,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Ссылка на таблицу persons",
		Column::KEY         => false,
		Column::ORIGIN_TYPE => "int4"
	];
}
