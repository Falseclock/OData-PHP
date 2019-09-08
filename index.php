<?php

use OData\Server;
use OData\Server\Configuration;

$composer = require('./vendor/autoload.php');

try {
    Configuration::me()
                 ->setContextPath("/rest/odata/")
                 ->setNameSpace("api.mp.kz")
                 ->setEntityPath("Tests\\Entities")
                 ->setComposer($composer)
    ;
    $server = new Server();

    $server->process();

} catch (Exception $e) {
    echo $e->getMessage();
}

