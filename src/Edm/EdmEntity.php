<?php

namespace Falseclock\OData\Edm;

use Exception;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Constraint;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;
use ReflectionException;

class EdmEntity
{
	/** @var Entity|string */
	private $className;
	/** @var Mapper $mapping */
	private $mapping;

	/**
	 * EdmEntity constructor.
	 *
	 * @param string|Entity $className
	 *
	 * @throws Exception
	 */
	public function __construct(string $className) {
		$this->className = $className;
		$this->mapping = $className::mappingClass();
	}

	/**
	 * @return string
	 */
	public function getAnnotation() {
		return $this->mapping->annotation();
	}

	/**
	 * @return Column[]
	 */
	public function getColumns(): iterable {
		$properties = get_object_vars($this->mapping);

		return $properties;
	}

	/**
	 * @return Constraint[]
	 */
	public function getConstraints(): iterable {
		return $this->mapping->getConstraints();
	}

	public function getName(): string {
		return (substr($this->className, strrpos($this->className, '\\') + 1));
	}
}