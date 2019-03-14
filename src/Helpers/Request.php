<?php
/**
 * <description should be written here>
 *
 * @package      OData\Server\Helpers
 * @copyright    Copyright © Nurlan Mukhanov <nurike@gmail.com>, March 2019
 * @license      MIT
 */

namespace OData\Server\Helpers;

class Request
{
    public $method;
    public $headers;
    public $remoteIP;

    public function __construct() {
        $this->remoteIP = (isset($_SERVER["HTTP_X_REAL_IP"]) ? $_SERVER["HTTP_X_REAL_IP"] : $_SERVER['REMOTE_ADDR']);
        $this->method = strtoupper($_SERVER['REQUEST_METHOD']);
    }
}