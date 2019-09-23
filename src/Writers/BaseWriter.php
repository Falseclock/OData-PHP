<?php

namespace Falseclock\OData\Writers;

use Exception;
use Falseclock\OData\Edm\EdmEntity;
use Falseclock\OData\Edm\EdmProvider;
use Falseclock\OData\Server\Configuration;
use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use ReflectionException;

abstract class BaseWriter implements Writer
{
	/** @var EdmProvider $edmProvider */
	protected $edmProvider;

	/**
	 * BaseWriter constructor.
	 *
	 * @param Request  $request
	 * @param Response $response
	 *
	 * @throws ReflectionException
	 */
	public function __construct(Request &$request, Response &$response) {
		$this->edmProvider = new EdmProvider();
	}

	/**
	 * @return string
	 * @throws Exception
	 */
	protected function getBaseUrl(): string {
		return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}" . Configuration::me()->getContextPath();
	}

	protected function getComplexes(): iterable {
		return $this->edmProvider->getComplexes();
	}

	/**
	 * @return EdmEntity[]
	 * @throws Exception
	 */
	protected function getEntities(): iterable {
		return $this->edmProvider->getEntities();
	}
}