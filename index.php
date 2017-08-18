<?php 

require_once("./dbManagers/db-manager-sqlite.php");
require_once("./router.php");

$router = new Router($db);
$router->route();


?>
