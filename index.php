<?php

use Falseclock\OData\Common\ConstructionRules;
use Falseclock\OData\Server;
use Falseclock\OData\Server\Configuration;
use Tests\Entities\TenderLotMap;

$composer = require('./vendor/autoload.php');

try {
	$test = new ConstructionRules();

	$test->getRegexp($test->odataUri);

	$mapper = TenderLotMap::me();

	Configuration::me()->setContextPath("/rest/odata/")->setNameSpace("api.mp.kz")->setEntityPath("Tests\\Entities")
		//->setContainer("MyContainerName")
				 ->setComposer($composer)
	;
	$server = new Server();
	$server->process()->out();

	$foo = 1;
}
catch(Exception $e) {
	echo $e->getMessage();
}

