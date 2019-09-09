<?php

namespace Falseclock\OData\Edm;

use Exception;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;

class EdmEntity
{
	/** @var Entity|string */
	private $className;
	/** @var Mapper $annotation */
	private $annotation;

	/**
	 * EdmEntity constructor.
	 *
	 * @param string|Entity $className
	 *
	 * @throws Exception
	 */
	public function __construct(string $className) {
		$this->className = $className;
		$this->annotation = $className::map();
	}

	public function getName(): string {
		return (substr($this->className, strrpos($this->className, '\\') + 1));
	}

	/**
	 * @return Column[]
	 */
	public function getProperties(): iterable {
		$properties = get_object_vars($this->annotation);

		return $properties;
	}
}