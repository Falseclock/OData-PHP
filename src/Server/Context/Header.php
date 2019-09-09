<?php

namespace Falseclock\OData\Server\Context;

class Header
{
    public $name;
    public $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }
}