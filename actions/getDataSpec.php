<?php


require_once "../controllers/db_controller.php";

$specName = $_GET["spec"];

print json_encode($DB->getSpecialityByName($specName));

?>