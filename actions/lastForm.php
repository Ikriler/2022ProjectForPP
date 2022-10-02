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

if($_SESSION['frame'] != "1") {

    //at_number
    $at_number = trim($_POST['at_number']);
    if(strlen($at_number) != 14) {
        $_SESSION['errors']['at_number'] = "Номер аттестата должен иметь 14 цифр";
        turnFrame();
    }
    if($at_number == "") {
        $_SESSION['errors']['at_number'] = "Поле не должно быть пустым";
        turnFrame();
    }
    if($DB->checkHasCertificateNumber($at_number)) {
        $_SESSION['errors']['at_number'] = "Данный номер аттестата уже существует";
        turnFrame();
    }

    //at_date
    $at_date = trim($_POST['at_date']);
    if ($at_date == "") {
        $_SESSION['errors']['at_date'] = "Выберите дату";
        turnFrame();
    }
    if (strtotime($at_date) >= time()) {
        $_SESSION['errors']['at_date'] = "Выберите прошлое время";
        turnFrame();
    }

    //at_name
    $at_name = trim($_POST['at_name']);
    if ($at_name == "") {
        $_SESSION['errors']['at_name'] = "Поле не должно быть пустым";
        turnFrame();
    }

    //at_scan
    $at_scan = trim($_SESSION["frameThirdData"]["at_scan"] ?? "");
    if ($at_scan == "") {
        $_SESSION['errors']['at_scan'] = "Загрузите изображение";
        turnFrame();
    }

    //at_priloj_scan
    $at_priloj_scan = trim($_SESSION["frameThirdData"]["at_priloj_scan"] ?? "");
    if ($at_priloj_scan == "") {
        $_SESSION['errors']['at_priloj_scan'] = "Загрузите изображение";
        turnFrame();
    }

    //middle_number
    $middle_number = trim($_POST['middle_number']);
    if ($middle_number == "") {
        $_SESSION['errors']['middle_number'] = "Поле не должно быть пустым";
        turnFrame();
    }
    if ($middle_number < 2 || $middle_number > 5) {
        $_SESSION['errors']['middle_number'] = "Средний балл должен быть не меньше 2 и не больше 5";
        turnFrame();
    }

    //spec
    $spec = $_POST["spec"];
    if(is_array($spec)) {
        if(count($spec) == 0) {
            $_SESSION['errors']['spec'] = "Выберите хотя бы одну специальность";
            turnFrame();
        }
    }
    if(is_string($spec)) {
        if(trim($spec) == "") {
            $_SESSION['errors']['spec'] = "Выберите хотя бы одну специальность";
            turnFrame();
        }
    }
    if($spec == null) {
        $_SESSION['errors']['spec'] = "Выберите хотя бы одну специальность";
        turnFrame();
    }

}

//end_validation

if($_SESSION['frame'] == "3") {
    $DB->createApplicant($_SESSION['frameFirstData'], $_SESSION['frameSecondData'], $_SESSION['frameThirdData']);
}



header("Location: ../index.php");

?>