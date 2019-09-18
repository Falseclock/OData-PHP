<?php

use Falseclock\DBD\Entity\Table;
use Tests\Entities\TenderLot;
use Tests\Entities\TenderLotMap;

$composer = require('./vendor/autoload.php');

try {

	$table = Table::getFromMapper(TenderLotMap::init(TenderLot::class));

//	Configuration::me()->setContextPath("/rest/odata/")->setNameSpace("api.mp.kz")->setEntityPath("Tests\\Entities")->setComposer($composer);
//	$server = new Server();
//	$server->process()->out();

	$foo = 1;
}
catch(Exception $e) {
	echo $e->getMessage();
}

