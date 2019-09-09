<?php

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