<?php

namespace Falseclock\OData\Edm;

use DBD\Entity\Column;
use DBD\Entity\Common\EntityException;
use DBD\Entity\Complex;
use DBD\Entity\Constraint;
use DBD\Entity\ConstraintRaw;
use DBD\Entity\Entity;
use DBD\Entity\Mapper;
use DBD\Entity\Table;
use Exception;

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
		$this->mapping = $className::map();
	}

	/**
	 * @return string
	 */
	public function getAnnotation() {
		return $this->mapping->getAnnotation();
	}

	/**
	 * @return string
	 */
	public function getClassName() {
		return $this->className;
	}

	/**
	 * @param Table $table
	 * @param       $columnOriginName
	 *
	 * @return int|string
	 * @throws EntityException
	 */
	public function getColumnByOriginName(Table $table, $columnOriginName) {
		foreach(array_merge($table->columns, $table->otherColumns) as $columnName => $columnValue) {
			if($columnValue->name == $columnOriginName) {
				return $columnName;
			}
		}
		throw new EntityException("Can't find column {$columnOriginName}");
	}

	/**
	 * @return Column[]
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

	/**
	 * @return Complex[]
	 * @throws Exception
	 */
	public function getComplexes(): iterable {
		return $this->mapping->getComplex();
	}

	/**
	 * @return Constraint[]
	 * @throws Exception
	 */
	public function getConstraints(): iterable {
		$constraints = $this->mapping->getConstraints();

		foreach($constraints as $constraint) {
			if($constraint instanceof ConstraintRaw and !$constraint->foreignTable instanceof Table) {
				/** @var Entity $foreignMapperClass */
				$foreignMapperClass = $constraint->class;
				$foreignMapper = $foreignMapperClass::map();

				/** @var string $foreignColumn */
				$foreignColumn = $constraint->foreignColumn;

				$constraint->foreignTable = $foreignMapper->getTable();
				$constraint->foreignColumn = $foreignMapper->findColumnByOriginName($foreignColumn);
			}
		}

		return $constraints;
	}

	/**
	 * @return string
	 */
	public function getName(): string {
		return (substr($this->className, strrpos($this->className, '\\') + 1));
	}
}