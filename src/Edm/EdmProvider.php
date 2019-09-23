<?php

namespace Falseclock\OData\Edm;

use Exception;
use Falseclock\DBD\Entity\Entity;
use Falseclock\DBD\Entity\Interfaces\Row;
use Falseclock\OData\Server\Configuration;
use ReflectionClass;
use ReflectionException;

class EdmProvider
{
	/** @var EdmEntity[] $entities */
	protected $entities;
	/** @var EdmComplex[] $complexes */
	protected $complexes;

	/**
	 * EdmEntitiesProvider constructor.
	 *
	 * @throws ReflectionException
	 * @throws Exception
	 */
	public function __construct() {
		$config = Configuration::me();

		foreach($config->getComposer()->getClassMap() as $className => $path) {
			if(strpos($className, $config->getEntityPath()) === 0) {

				$reflector = new ReflectionClass($className);

				if($reflector->isSubclassOf(new ReflectionClass(Entity::class))) {
					if($reflector->implementsInterface(Row::class)) {
						$this->complexes[$className] = new EdmComplex($className);
					}
					else {
						$this->entities[$className] = new EdmEntity($className);
					}
				}
			}
		}
	}

	/**
	 * @return EdmComplex[]
	 */
	public function getComplexes(): iterable {
		return $this->complexes;
	}

	/**
	 * @return EdmEntity[]
	 * @throws Exception
	 */
	public function getEntities(): iterable {
		return $this->entities;
	}
}