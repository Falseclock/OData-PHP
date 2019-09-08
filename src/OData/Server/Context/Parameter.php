<?php

namespace OData\Server\Context;

class Parameter
{
	public $type;
	public $value;

	public function __construct(string $type, string $value) {
		$this->type = $type;
		$this->value = $value;
	}
}