<?php
/**
 * <description should be written here>
 *
 * @package      Falseclock\OData\Writers
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 *
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, сентябрь 2019
 */

namespace Falseclock\OData\Writers;


use Exception;
use Falseclock\OData\Handlers\EntitiesProvider;
use Falseclock\OData\Handlers\Entity;
use Falseclock\OData\Server\Configuration;

abstract class BaseWriter implements Writer
{
    /**
     * @return string
     * @throws Exception
     */
    protected function getBaseUrl(): string
    {
        return "{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}" . Configuration::me()->getContextPath();
    }

    /**
     * @return Entity[]
     * @throws Exception
     */
    protected function getEntities(): iterable
    {
        return (new EntitiesProvider())->getEntities();
    }
}