<?php
/**
 * <description should be written here>
 *
 * @package      OData\Server
 * @copyright    Copyright © Nurlan Mukhanov <nurike@gmail.com>, March 2019
 * @license      MIT
 */

namespace OData\Server;

use OData\Server\Helpers\Config;
use OData\Server\Helpers\Info;

class ODataServer
{
    protected $config;

    /**
     * ODataServer constructor.
     *
     * @param \OData\Server\Helpers\Config $config
     */
    public function __construct(Config $config) {
        $this->config = $config;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function process() {

        // 1. Read all headers and requests
        Info::me()->parseRequest();

        return $this;
    }
}