<?php

namespace Falseclock\OData\Edm;

use Exception;
use Falseclock\DBD\Entity\Column;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Mapper;

class EdmComplex
{
	/** @var Entity|string */
	private $className;
	/** @var Mapper $mapping */
	private $mapping;

	/**
	 * EdmComplex constructor.
	 *
	 * @param string|Entity $className
	 *
	 * @throws Exception
	 */
	public function __construct(string $className) {
		$this->className = $className;
		$this->mapping = $className::map();
	}

	/**
	 * FIXME: два одинаковых метода с EdmEntity
	 *
	 * @return iterable
	 * @throws Exception
	 */
	public function getColumns(): iterable {
		$properties = array_merge($this->mapping->getColumns(), $this->mapping->getOtherColumns());
		foreach($properties as $propertyName => $propertyValue) {
			if(!$propertyValue instanceof Column) {
				unset($properties[$propertyName]);
			}
		}

		return $properties;
	}
}