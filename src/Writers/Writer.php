<?php

namespace Falseclock\OData\Writers;

use Falseclock\OData\Server\Context\Request;
use Falseclock\OData\Server\Context\Response;

interface Writer
{
    function __construct(Request &$request, Response &$response);

    public function getStringOutput();

    public function getWriter();

    public function serviceDocument();
}