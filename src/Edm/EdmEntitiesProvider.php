<?php

namespace Falseclock\OData\Edm;

use Exception;
use Falseclock\DBD\Entity\Entity;
use Falseclock\OData\Server\Configuration;
use ReflectionClass;

class EdmEntitiesProvider
{
    public function __construct()
    {
    }

    /**
	 * @return EdmEntity[]
     * @throws Exception
     */
    public function getEntities(): iterable
    {
        $config = Configuration::me();
        $entities = [];
        foreach ($config->getComposer()->getClassMap() as $className => $path) {
            if (strpos($className, $config->getEntityPath()) === 0) {

				$reflector = new ReflectionClass($className);

				if($reflector->isSubclassOf(new ReflectionClass(Entity::class))) {
					$entities[] = new EdmEntity($className);
                }
            }
        }

        return $entities;
    }
}