<?php

use DBD\Base\Config;
use DBD\Base\Options;
use DBD\Pg;

require_once("./requisites.php");

/**
 * Create requisites.php file with these variables
 *
 * $DB_HOST = "127.0.0.1";
 * $DB_PORT = 5432;
 * $DB_NAME = "odata";
 * $DB_USER = "odata";
 * $DB_PASSWORD="super_secret";
 *
 */

$config = new Config($DB_HOST, $DB_PORT, $DB_NAME, $DB_USER, $DB_PASSWORD, "odata-test");
$options = new Options(true, true, true, true, true, true, true, true);

$db = new Pg($config, $options);
$db->connect();
