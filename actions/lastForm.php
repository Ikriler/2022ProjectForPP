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

require_once "../controllers/randomizer.php";

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

header("Location: ../index.php");

?>