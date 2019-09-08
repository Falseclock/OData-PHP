<?php

use OData\Server;
use OData\Server\Configuration;

$composer = require('./vendor/autoload.php');

try {
	Configuration::me()->setContextPath("/rest/odata/")->setNameSpace("api.mp.kz");
}
catch(Exception $e) {
}

$server = new Server();

$server->process();

dump($server->getRequest());