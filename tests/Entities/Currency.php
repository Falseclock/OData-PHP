<?php

namespace Tests\Entities;

use DBD\Entity\Column;
use DBD\Entity\Entity;
use DBD\Entity\Mapper;
use DBD\Entity\Primitive;

class Currency extends Entity
{
	const SCHEME = "handbook";
	const TABLE  = "currencies";
	/**
	 * Идентификатор валюты
	 *
	 * @var int
	 * @see CurrencyMap::id
	 */
	public $id;
	/**
	 * Название валюты
	 *
	 * @var string
	 * @see CurrencyMap::$name
	 */
	public $name;
	/**
	 * Короткое название валюты
	 *
	 * @var string
	 * @see CurrencyMap::shortName
	 */
	public $shortName;
	/**
	 * короткая аббревиатура валюты
	 *
	 * @var string
	 * @see CurrencyMap::abbreviation
	 */
	public $abbreviation;
	/**
	 * Буквенный символ валюты
	 *
	 * @var string
	 * @see CurrencyMap::symbol
	 */
	public $symbol;
	/**
	 *
	 *
	 * @var string
	 * @see CurrencyMap::code
	 */
	public $code;
}

class CurrencyMap extends Mapper
{
	const ANNOTATION = "Таблица валют";
	/**
	 * @var Column
	 * @see Currency::$id
	 */
	public $id = [
		Column::NAME        => "currency_id",
		Column::TYPE        => Primitive::Int32,
		Column::DEFAULT     => "nextval('currencies_currency_id_seq'::regclass)",
		Column::NULLABLE    => false,
		Column::ANNOTATION  => "Идентификатор валюты",
		Column::KEY         => true,
		Column::ORIGIN_TYPE => "int4"
	];
	/**
	 * @var Column
	 * @see Currency::$name
	 */
	public $name = [
		Column::NAME        => "currency_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 32,
		Column::ANNOTATION  => "Название валюты",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Currency::$shortName
	 */
	public $shortName = [
		Column::NAME        => "currency_short_name",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 16,
		Column::ANNOTATION  => "Короткое название валюты",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Currency::$abbreviation
	 */
	public $abbreviation = [
		Column::NAME        => "currency_abbreviation",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 8,
		Column::ANNOTATION  => "короткая аббревиатура валюты",
		Column::ORIGIN_TYPE => "varchar"
	];
	/**
	 * @var Column
	 * @see Currency::$symbol
	 */
	public $symbol = [
		Column::NAME        => "currency_symbol",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 1,
		Column::ANNOTATION  => "Буквенный символ валюты",
		Column::ORIGIN_TYPE => "bpchar"
	];
	/**
	 * @var Column
	 * @see Currency::$code
	 */
	public $code = [
		Column::NAME        => "currency_code",
		Column::TYPE        => Primitive::String,
		Column::NULLABLE    => false,
		Column::MAXLENGTH   => 3,
		Column::ORIGIN_TYPE => "varchar"
	];
}
