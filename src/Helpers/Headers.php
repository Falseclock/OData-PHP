<?php
/**
 * <description should be written here>
 *
 * @package      OData\Server\Helpers
 * @copyright    Copyright © Nurlan Mukhanov <nurike@gmail.com>, March 2019
 * @license      MIT
 */

namespace OData\Server\Helpers;

class Headers
{
    public $contentType;
    public $userAgent;
    public $contentLength;

    public function __construct(array $headers) {
        $this->contentType = $_SERVER['CONTENT_TYPE'];
        $this->contentLength = intval($_SERVER['CONTENT_LENGTH']);
    }
}