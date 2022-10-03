<?php

session_start();

require_once "../controllers/db_controller.php";

if(!isset($_SESSION['auth']) || $_SESSION['auth'] != true) {
    header("Location: ../index.php");
    exit();
}

if(isset($_POST["ID_Applicant"])) {

    $applicant_id = $_POST["ID_Applicant"];
    $DB->deleteApplican($applicant_id);
}


?>
