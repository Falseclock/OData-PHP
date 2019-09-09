<?php

namespace Falseclock\OData\Handlers;

use Exception;
use Falseclock\OData\Server\Configuration;
use ReflectionClass;

class EntitiesProvider
{
    public function __construct()
    {
    }

    /**
     * @return Entity[]
     * @throws Exception
     */
    public function getEntities(): iterable
    {
        $config = Configuration::me();
        $entities = [];
        foreach ($config->getComposer()->getClassMap() as $className => $path) {
            if (strpos($className, $config->getEntityPath()) === 0) {
                if (method_exists($className, 'map')) {

                    $reflector = new ReflectionClass($className);

                    $entities[] = new Entity($className);
                }
            }
        }

        return $entities;
    }
}