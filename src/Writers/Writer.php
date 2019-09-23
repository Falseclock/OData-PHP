<?php

namespace Falseclock\OData\Writers;

use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;
use XMLWriter;

interface Writer
{
	function __construct(Request &$request, Response &$response);

	/**
	 * @return string
	 */
	public function getStringOutput();

	/**
	 * @return mixed|XMLWriter
	 */
	public function getWriter();

	/**
	 * @return self
	 */
	public function metadata();

	/**
	 * @return self
	 */
	public function serviceDocument();
}