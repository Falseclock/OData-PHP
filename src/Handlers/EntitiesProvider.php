<?php
/**
 * <description should be written here>
 *
 * @package      OData\Handlers
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 *
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, сентябрь 2019
 */

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