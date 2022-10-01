<?php

session_start();

require_once "../controllers/randomizer.php";

$root = $_SERVER["DOCUMENT_ROOT"];

if(isset($_SESSION["frameFirstData"]["photoFace"])) {
    $photo = $_SESSION["frameFirstData"]["photoFace"];
}

$_SESSION["frameFirstData"] = [
    "name" => $_POST["name"],
    "surname" => $_POST["surname"],
    "patronymic" => $_POST["patronymic"],
    "email" => $_POST["email"],
    "phone" => $_POST["phone"],
    "birthDay" => $_POST["birthDay"],
    "sex" => $_POST["sex"],
    "goldGTO" => $_POST["goldGTO"],
    "winner" => $_POST["winner"],
];

if(isset($photo)) {
    $_SESSION["frameFirstData"]["photoFace"] = $photo; 
}

if(isset($_FILES['photoFace']) && $_FILES['photoFace']['name'] != '') {
    $tmpFile = $_FILES['photoFace']['tmp_name'];
    $ext = pathinfo($_FILES['photoFace']['name'], PATHINFO_EXTENSION);
    $newFile = $root . '/images/docs/'.random_string(10).".".$ext;
    $result = move_uploaded_file($tmpFile, $newFile);   
    $_SESSION["frameFirstData"]["photoFace"] = $newFile; 
}

$_SESSION["frame"] = "1";

header("Location: ../index.php");
