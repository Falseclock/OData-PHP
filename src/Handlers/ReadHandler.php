<?php

namespace Falseclock\OData\Edm;

use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;

class ReadHandler extends BaseHandler
{
	public function __construct(Request &$request, Response &$response) {
		parent::__construct($request, $response);
	}
}