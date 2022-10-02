<?php

session_start();
require_once "../controllers/db_controller.php";

if(!isset($_SESSION['auth']) || $_SESSION['auth'] != true) {
    header("Location: ../index.php");
}

print json_encode($DB->getApplicantsForTableAdmin());


?>