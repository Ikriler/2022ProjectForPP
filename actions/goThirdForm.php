<?php

session_start();

if (isset($_POST["submit"])) {
    if ($_POST["submit"] == "back") {
        $_SESSION["frame"] = "0";
    }
    if ($_POST["submit"] == "next") {
        $_SESSION["frame"] = "2";
    }
}

require_once "../controllers/randomizer.php";
require_once "../controllers/db_controller.php";

function turnFrame()
{
    $_SESSION["frame"] = "1";
}

$root = $_SERVER["DOCUMENT_ROOT"];

if (isset($_SESSION["frameSecondData"]["first_scan"])) {
    $first_scan = $_SESSION["frameSecondData"]["first_scan"];
}

if (isset($_SESSION["frameSecondData"]["second_scan"])) {
    $second_scan = $_SESSION["frameSecondData"]["second_scan"];
}

$_SESSION["frameSecondData"] = [
    "pass_seria" => $_POST["pass_seria"],
    "pass_number" => $_POST["pass_number"],
    "date_out" => $_POST["date_out"],
    "who_otdal" => $_POST["who_otdal"],
    "podrazdel_number" => $_POST["podrazdel_number"],
];

if (isset($first_scan)) {
    $_SESSION["frameSecondData"]["first_scan"] = $first_scan;
}

if (isset($second_scan)) {
    $_SESSION["frameSecondData"]["second_scan"] = $second_scan;
}

if (isset($_FILES['first_scan']) && $_FILES['first_scan']['name'] != '') {
    $tmpFile = $_FILES['first_scan']['tmp_name'];
    $ext = pathinfo($_FILES['first_scan']['name'], PATHINFO_EXTENSION);
    $newFile = $root . '/images/docs/' . random_string(10) . "." . $ext;
    $result = move_uploaded_file($tmpFile, $newFile);
    $_SESSION["frameSecondData"]["first_scan"] = $newFile;
}

if (isset($_FILES['second_scan']) && $_FILES['second_scan']['name'] != '') {
    $tmpFile = $_FILES['second_scan']['tmp_name'];
    $ext = pathinfo($_FILES['second_scan']['name'], PATHINFO_EXTENSION);
    $newFile = $root . '/images/docs/' . random_string(10) . "." . $ext;
    $result = move_uploaded_file($tmpFile, $newFile);
    $_SESSION["frameSecondData"]["second_scan"] = $newFile;
}

//validation

if ($_SESSION['frame'] != "0") {

    //passport
    $pass_seria = trim($_POST['pass_seria']);
    $pass_number = trim($_POST['pass_number']);

    if (strlen($pass_seria) != 4 || strlen($pass_number) != 6) {
        $_SESSION['errors']['pass_seria'] = "Поля должны иметь вид 'Серия: 1111; Номер: 111111';";
        turnFrame();
    }
    if ($pass_seria == "" || $pass_number == "") {
        $_SESSION['errors']['pass_seria'] = "Поля серии и номера не должны быть пустыми";
        turnFrame();
    }
    if ($DB->checkHasPassport($pass_seria, $pass_number)) {
        $_SESSION['errors']['pass_seria'] = "Такой паспорт уже существует";
        turnFrame();
    }

    //date_out

    $date_out = trim($_POST['date_out']);
    if ($date_out == "") {
        $_SESSION['errors']['date_out'] = "Выберите дату";
        turnFrame();
    }
    if (strtotime($date_out) >= time()) {
        $_SESSION['errors']['date_out'] = "Выберите прошлое время";
        turnFrame();
    }

    //who_otdal
    $who_otdal = trim($_POST['who_otdal']);
    if ($who_otdal == "") {
        $_SESSION['errors']['who_otdal'] = "Поле не должно быть пустым";
        turnFrame();
    }

    //podrazdel_number
    $podrazdel_number = trim($_POST['podrazdel_number']);
    if (strlen($podrazdel_number) != 6) {
        $_SESSION['errors']['podrazdel_number'] = "Поле должно иметь формат '123456'";
        turnFrame();
    }
    if ($podrazdel_number == "") {
        $_SESSION['errors']['podrazdel_number'] = "Поле не должно быть пустым";
        turnFrame();
    }

    //first_scan
    $first_scan = trim($_SESSION["frameSecondData"]["first_scan"] ?? "");
    if ($first_scan == "") {
        $_SESSION['errors']['first_scan'] = "Загрузите изображение";
        turnFrame();
    }

    //second_scan
    $second_scan = trim($_SESSION["frameSecondData"]["second_scan"] ?? "");
    if ($second_scan == "") {
        $_SESSION['errors']['second_scan'] = "Загрузите изображение";
        turnFrame();
    }
}

//end validation 


header("Location: ../index.php");

?>