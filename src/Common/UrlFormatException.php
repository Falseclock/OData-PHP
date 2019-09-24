<?php

namespace Falseclock\OData\Common;

use Exception;

class UrlFormatException extends Exception
{
	public function __construct($message) {
		parent::__construct($message);
	}
}