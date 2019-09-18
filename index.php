<?php

use Falseclock\OData\Server;
use Falseclock\OData\Server\Configuration;
use Tests\Entities\TenderLotMap;

$composer = require('./vendor/autoload.php');

try {

	$mapper = TenderLotMap::me();

	Configuration::me()->setContextPath("/rest/odata/")->setNameSpace("api.mp.kz")->setEntityPath("Tests\\Entities")->setComposer($composer);
	$server = new Server();
	$server->process()->out();

	$foo = 1;
}
catch(Exception $e) {
	echo $e->getMessage();
}

