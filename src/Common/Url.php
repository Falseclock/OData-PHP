<?php

namespace Falseclock\OData\Common;

class Url
{
	public $scheme;
	public $host;
	public $port;
	public $user;
	public $password;
	public $path;
	/** @var string $query everything after ? sign */
	public $query;
	public $fragment;
	public $raw;

	/**
	 * Url constructor.
	 * TODO: https://habr.com/ru/post/100961/
	 *
	 * @param string $url
	 *
	 * @throws UrlFormatException
	 */
	public function __construct(string $url) {

		$this->raw = $url;

		$urlParse = parse_url($url);

		if($urlParse === false)
			throw new UrlFormatException(Messages::urlMalformedUrl($url));

		foreach($urlParse as $key => $value) {
			$this->$key = $value;
		}
	}
}