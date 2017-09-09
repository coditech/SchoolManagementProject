<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, cache-control');
header('Access-Control-Allow-Credentials', true);
require_once("./dbManagers/db-manager-sqlite.php");
require_once("./router.php");

$router = new Router($db);
$router->route();

