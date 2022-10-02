<?php

session_start();

if(isset($_POST["submit"])) {
    if($_POST["submit"] == "back") {
        $_SESSION["frame"] = "1";
    }
    if($_POST["submit"] == "next") {
        $_SESSION["frame"] = "3";
    }
}

function turnFrame() {
    $_SESSION["frame"] = "2";
}

require_once "../controllers/randomizer.php";
require_once "../controllers/db_controller.php";

$root = $_SERVER["DOCUMENT_ROOT"];

if(isset($_SESSION["frameThirdData"]["at_scan"])) {
    $at_scan = $_SESSION["frameThirdData"]["at_scan"];
}

if(isset($_SESSION["frameThirdData"]["at_priloj_scan"])) {
    $at_priloj_scan = $_SESSION["frameThirdData"]["at_priloj_scan"];
}

$_SESSION["frameThirdData"] = [
    "at_number" => $_POST["at_number"],
    "at_name" => $_POST["at_name"],
    "at_date" => $_POST["at_date"],
    "middle_number" => $_POST["middle_number"],
    "spec" => $_POST["spec"],
];

if(isset($at_scan)) {
    $_SESSION["frameThirdData"]["at_scan"] = $at_scan; 
}

if(isset($at_priloj_scan)) {
    $_SESSION["frameThirdData"]["at_priloj_scan"] = $at_priloj_scan; 
}

if(isset($_FILES['at_scan']) && $_FILES['at_scan']['name'] != '') {
    $tmpFile = $_FILES['at_scan']['tmp_name'];
    $ext = pathinfo($_FILES['at_scan']['name'], PATHINFO_EXTENSION);
    $newFile = $root . '/images/docs/'.random_string(10).".".$ext;
    $result = move_uploaded_file($tmpFile, $newFile);   
    $_SESSION["frameThirdData"]["at_scan"] = $newFile; 
}

if(isset($_FILES['at_priloj_scan']) && $_FILES['at_priloj_scan']['name'] != '') {
    $tmpFile = $_FILES['at_priloj_scan']['tmp_name'];
    $ext = pathinfo($_FILES['at_priloj_scan']['name'], PATHINFO_EXTENSION);
    $newFile = $root . '/images/docs/'.random_string(10).".".$ext;
    $result = move_uploaded_file($tmpFile, $newFile);   
    $_SESSION["frameThirdData"]["at_priloj_scan"] = $newFile; 
}

//validation

//at_number

if($_SESSION['frame'] != "1") {
    $at_number = trim($_POST['at_number']);
    if($at_number == "") {
        $_SESSION['errors']['at_number'] = "Поле не должно быть пустым";
        turnFrame();
    }
    if($DB->checkHasCertificateNumber($at_number)) {
        $_SESSION['errors']['at_number'] = "Данный номер аттестата уже существует";
        turnFrame();
    }
}

//end_validation

if($_SESSION['frame'] == "3") {
    $DB->createApplicant($_SESSION['frameFirstData'], $_SESSION['frameSecondData'], $_SESSION['frameThirdData']);
}



header("Location: ../index.php");

?>