<?php

session_start();

if(isset($_POST["submit"])) {
    if($_POST["submit"] == "back") {
        $_SESSION["frame"] = "0";
    }
    if($_POST["submit"] == "next") {
        $_SESSION["frame"] = "2";
    }
}

require_once "../controllers/randomizer.php";

$root = $_SERVER["DOCUMENT_ROOT"];

if(isset($_SESSION["frameSecondData"]["first_scan"])) {
    $first_scan = $_SESSION["frameSecondData"]["first_scan"];
}

if(isset($_SESSION["frameSecondData"]["second_scan"])) {
    $second_scan = $_SESSION["frameSecondData"]["second_scan"];
}

$_SESSION["frameSecondData"] = [
    "pass_seria" => $_POST["pass_seria"],
    "pass_number" => $_POST["pass_number"],
    "date_out" => $_POST["date_out"],
    "who_otdal" => $_POST["who_otdal"],
    "podrazdel_number" => $_POST["podrazdel_number"],
];

if(isset($first_scan)) {
    $_SESSION["frameSecondData"]["first_scan"] = $first_scan; 
}

if(isset($second_scan)) {
    $_SESSION["frameSecondData"]["second_scan"] = $second_scan; 
}

if(isset($_FILES['first_scan']) && $_FILES['first_scan']['name'] != '') {
    $tmpFile = $_FILES['first_scan']['tmp_name'];
    $ext = pathinfo($_FILES['first_scan']['name'], PATHINFO_EXTENSION);
    $newFile = $root . '/images/docs/'.random_string(10).".".$ext;
    $result = move_uploaded_file($tmpFile, $newFile);   
    $_SESSION["frameSecondData"]["first_scan"] = $newFile; 
}

if(isset($_FILES['second_scan']) && $_FILES['second_scan']['name'] != '') {
    $tmpFile = $_FILES['second_scan']['tmp_name'];
    $ext = pathinfo($_FILES['second_scan']['name'], PATHINFO_EXTENSION);
    $newFile = $root . '/images/docs/'.random_string(10).".".$ext;
    $result = move_uploaded_file($tmpFile, $newFile);   
    $_SESSION["frameSecondData"]["second_scan"] = $newFile; 
}

header("Location: ../index.php");

?>