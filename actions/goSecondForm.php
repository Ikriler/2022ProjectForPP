<?php

session_start();

require_once "../controllers/randomizer.php";
require_once "../controllers/db_controller.php";

function turnFrame() {
    $_SESSION["frame"] = "0";
}

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
    "goldGTO" => $_POST["goldGTO"] == 1 ? 1 : 0,
    "winner" => $_POST["winner"] == 1 ? 1 : 0,
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

//validation

$_SESSION["frame"] = "1";

//email
$email = trim($_POST['email']);
if($email == "") {
    $_SESSION['errors']['email'] = "Поле не должно быть пустым";
    turnFrame();
}
if($DB->checkHasEmail($email)) {
    $_SESSION['errors']['email'] = "Данный email уже существует";
    turnFrame();
}

//phone

$phone = trim($_POST['phone']);
if(strlen($phone) != 11) {
    $_SESSION['errors']['phone'] = "Телефон должен иметь вид 89999999999";
    turnFrame();
}
if($phone == "") {
    $_SESSION['errors']['phone'] = "Поле не должно быть пустым";
    turnFrame();
}
if($DB->checkHasPhone($phone)) {
    $_SESSION['errors']['phone'] = "Данный телефон уже существует";
    turnFrame();
}


//name

$name = trim($_POST['name']);
if($name == "") {
    $_SESSION['errors']['name'] = "Поля ФИО не должны быть пустыми";
    turnFrame();
}
if(strlen($name) > 30) {
    $_SESSION['errors']['name'] = "Поля ФИО не должны превышать 30 символов";
    turnFrame();
}

//surname
$surname = trim($_POST['surname']);
if($surname == "") {
    $_SESSION['errors']['name'] = "Поля ФИО не должны быть пустыми";
    turnFrame();
}
if(strlen($surname) > 30) {
    $_SESSION['errors']['name'] = "Поля ФИО не должны превышать 30 символов";
    turnFrame();
}

//patronymic
$patronymic = trim($_POST['patronymic']);
if($patronymic == "") {
    $_SESSION['errors']['name'] = "Поля ФИО не должны быть пустыми";
    turnFrame();
}
if(strlen($patronymic) > 30) {
    $_SESSION['errors']['name'] = "Поля ФИО не должны превышать 30 символов";
    turnFrame();
}

//birthDay

$birthDay = trim($_POST['birthDay']);
if($birthDay == "") {
    $_SESSION['errors']['birthDay'] = "Выберите дату";
    turnFrame();
}
if(strtotime($birthDay) >= time()) {
    $_SESSION['errors']['birthDay'] = "Выберите прошлое время";
    turnFrame();
}

//photoFace

$photoFace = trim($_SESSION["frameFirstData"]["photoFace"] ?? "");
if($photoFace == "") {
    $_SESSION['errors']['photoFace'] = "Загрузите изображение";
    turnFrame();
}


//end_validation


header("Location: ../index.php");
