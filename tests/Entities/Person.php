<?php

namespace Tests\Entities;

use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Complex;
use Falseclock\DBD\Entity\Constraint;
use Falseclock\DBD\Entity\Embedded;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Join;
use Falseclock\DBD\Entity\Mapper;
use Falseclock\DBD\Entity\Primitive;
use Falseclock\DBD\Entity\Type;
use Tests\Entities\Complex\CompanyRow;
use Tests\Entities\Complex\UserRow;

class Person extends Entity
{
	const SCHEME = "membership";
	const TABLE  = "persons";
	/**
	 * Идентификатор пользователя, серийный, уникальный, первичный.
	 *
	 * @var int
	 * @see PersonMap::$id
	 */
	public $id;
	/**
	 * Реальное имя пользователя.; TODO: может быть NULL.; TODO: убрать дефолтное значение; TODO: сконвертить дефисы в null
	 *
	 * @var string
	 * @see PersonMap::$firstName
	 */
	public $firstName;
	/**
	 * Фамилия пользователя. Может быть NULL; TODO: изменить дефолтное значение
	 *
	 * @var string
	 * @see PersonMap::$lastName
	 */
	public $lastName;
	/**
	 * Электронный почтовый адрес пользователя. Предполагается, что это поле будет уникальным и не пустым. Для обратной совместимости мы будем сохранять старый email, в
	 * случае деактивации пользователя, в поле metadata.; TODO: удаление всех не релевантных данных и дубликатов
	 *
	 * @var string
	 * @see PersonMap::$email
	 */
	public $email;
	/**
	 * Пароль с использованием соли и алгоритма шифрования BCRYPT или BLOWFISH.; Например "$2y$07$BCryptRequires22Chrcte/VlQH0piJtjXl.0t1XkA8pw9dMXTpOq" где; $2y$ -
	 * алгоритм шифрования; 07$ - опции алгоритма; BCryptRequires22Chrcte/VlQH0piJtjXl. - соль пароля; 0t1XkA8pw9dMXTpOq - хэш пароля
	 *
	 * @var string
	 * @see PersonMap::$password
	 */
	public $password;
	/**
	 * ИИН пользователя. Так как у нас могут быть зарегистрированы не только казахстанцы, то поле может иметь NULL значение; TODO: сделать уникальным
	 *
	 * @var string
	 * @see PersonMap::$identity
	 */
	public $identity;
	/**
	 * Статус активности пользователя.
	 *
	 * @var boolean
	 * @see PersonMap::$isActive
	 */
	public $isActive;
	/**
	 * Данные пользователя, хранятся в виде объекта, например:; {; registration_date: "2018-01-30 13:55:35.00132+06",; email_confimed: true,; state: "active",; }
	 *
	 * @var string
	 * @see PersonMap::$metaData
	 */
	public $metaData;
	/**
	 * Старые метеданные пользователя, от которых надо избавиться. TODO: удалить после перехода на новую платформу
	 *
	 * @var string
	 * @see PersonMap::$metaDataOld
	 */
	public $metaDataOld;
	/**
	 * Таблица доступа к площадке. Здесь определяются названия видов доступа к площадке, допустим:; 1. Гость; 2. Поисковая машина; 3. Новый пользователь без компании; 4.
	 * Компания на пробном тарифе; 5. Компания на платном тарифе; 6. Народный банк; 7. Air Astana
	 *
	 * @var Admission
	 * @see PersonMap::$Admission
	 */
	public $Admission;
	/**
	 * Отсутствует в базе, создано искусственно
	 * Персональные доступы, которые работают только в админке
	 *
	 * @var Admission[]
	 * @see PersonMap::$Admissions
	 */
	public $Admissions = [];
	/**
	 * Отсутствует в базе, создано искусственно
	 * Персональные доступы, которые работают только в админке
	 *
	 * @var Permission[]
	 * @see PersonMap::$Permissions
	 */
	public $Permissions = [];
	/**
	 * Отсутствует в базе, создано искусственно
	 * Персональные доступы, которые работают только в админке
	 *
	 * @var User[]
	 * @see PersonMap::$User
	 */
	public $User;
	/**
	 * Отсутствует в базе, создано искусственно
	 * Персональные доступы, которые работают только в админке
	 *
	 * @var Company[]
	 * @see PersonMap::$Company
	 */
	public $Company;
}

class PersonMap extends Mapper
{
	const ANNOTATION = "Таблица регистрации пользователей. Содержит уникальные регистрации.";
	/**
	 * @var Column
	 * @see Person::$id
	 */
	public $id = [
		Column::NAME        => "person_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('comp_employees_empid_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор пользователя, серийный, уникальный, первичный.",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Person::$firstName
	 */
	public $firstName = [
		Column::NAME        => "person_first_name",
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
		Column::NAME        => "person_last_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Фамилия пользователя. Может быть NULL; TODO: изменить дефолтное значение",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Person::$email
	 */
	public $email = [
		Column::NAME        => "person_email",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Электронный почтовый адрес пользователя. Предполагается, что это поле будет уникальным и не пустым. Для обратной совместимости мы будем сохранять старый email, в случае деактивации пользователя, в поле metadata.; TODO: удаление всех не релевантных данных и дубликатов",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Person::$password
	 */
	public $password = [
		Column::NAME        => "person_password",
		Column::TYPE        => Primitive::String,
		Column::DEFAULT     => "'0'::character varying",
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 256,
		Column::ANNOTATION  => "Пароль с использованием соли и алгоритма шифрования BCRYPT или BLOWFISH.",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Person::$identity
	 */
	public $identity = [
		Column::NAME        => "person_identity",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "ИИН пользователя. Так как у нас могут быть зарегистрированы не только казахстанцы, то поле может иметь NULL значение; TODO: сделать уникальным",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Person::$isActive
	 */
	public $isActive = [
		Column::NAME        => "person_is_active",
		Column::TYPE        => Primitive::Boolean,
		Column::DEFAULT     => "true",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Статус активности пользователя. ",
		Column::ORIGIN_TYPE => "bool"
	];
	/**
	 * @var Column
	 * @see Person::$metaData
	 */
	public $metaData = [
		Column::NAME        => "person_metadata",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Данные пользователя, хранятся в виде объекта, например:; {; registration_date: \"2018-01-30 13:55:35.00132+06\",; email_confimed: true,; state: \"active\",; }",
		Column::ORIGIN_TYPE => "jsonb"
	];
	/**
	 * @var Column
	 * @see Person::$metaDataOld
	 */
	public $metaDataOld = [
		Column::NAME        => "person_metadata_old",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Старые метеданные пользователя, от которых надо избавиться. TODO: удалить после перехода на новую платформу",
		Column::ORIGIN_TYPE => "jsonb"
	];
	/**
	 * Искусственно, берется из JOIN
	 *
	 * @see Person::$Admission
	 * @var Embedded
	 */
	public $Admissions = [
		Embedded::NAME         => "person_admissions",
		Embedded::DB_TYPE      => Type::Json,
		Embedded::IS_ITERABLE  => true,
		Embedded::ENTITY_CLASS => Admission::class
	];
	/**
	 * Искусственно, берется из вьюшки
	 *
	 * @see Person::$Admission
	 * @var Embedded
	 */
	public $Permissions = [
		Embedded::NAME         => "person_permissions",
		Embedded::DB_TYPE      => Type::Json,
		Embedded::IS_ITERABLE  => true,
		Embedded::ENTITY_CLASS => Permission::class
	];
	/**
	 * Ссылка на admissions. Поле позволяет задать разрешения и права для тех, кто зарегистрировался но не указал свою компанию
	 *
	 * @var Column
	 */
	protected $admissionId = [
		Column::NAME        => "admission_id",
		Column::TYPE        => Primitive::Int32,
		Column::ORIGIN_TYPE => "int4"
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
	/**
	 * Искусственно, берется из JOIN
	 *
	 * @see Person::$User
	 * @var Complex
	 */
	protected $User = [
		Complex::TYPE => UserRow::class,
	];
	/**
	 * Искусственно, берется из JOIN
	 *
	 * @see Person::$Company
	 * @var Complex
	 */
	protected $Company = [
		Complex::TYPE => CompanyRow::class
	];
}
