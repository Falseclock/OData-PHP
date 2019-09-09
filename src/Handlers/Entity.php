<?php

namespace Falseclock\OData\Handlers;

class Entity
{
    private $className;

    public function __construct(string $className)
    {
        $this->className = $className;
    }

    public function getName(): string
    {
        return (substr($this->className, strrpos($this->className, '\\') + 1));
    }
}