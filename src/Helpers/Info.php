<?php
/**
 * <description should be written here>
 *
 * @package      OData\Server\Helpers
 * @copyright    Copyright © Nurlan Mukhanov <nurike@gmail.com>, March 2019
 * @license      MIT
 */

namespace OData\Server\Helpers;

class Info implements Instantiatable
{
    use Singleton;
    /** @var \OData\Server\Helpers\Request $request contains all necessary request data */
    public $request;
    /** @var \OData\Server\Helpers\Headers $headers contains all necessary headers came with request */
    public $headers;

    /**
     * @return $this;
     * @throws \Exception
     */
    public static function me() {
        return Singleton::getInstance(__CLASS__);
    }

    /**
     *
     */
    public function parseRequest() {

        $this->request = new Request;
        $this->headers = new Headers(getallheaders());
    }
}