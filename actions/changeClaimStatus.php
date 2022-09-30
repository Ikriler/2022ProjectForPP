<?php

session_start();

require_once "../controllers/settings_controller.php";

if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: ../index.php");
    exit();
}

$status = $_POST['status'];


Setting::setClaimStatus($status);

header("Location: ../pages/adminPanel.php");


?>