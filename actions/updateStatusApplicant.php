<?php

require_once "../controllers/db_controller.php";

session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] != true) {
    header("Location: ../index.php");
    exit();
}

$nextStatus = "";

switch($_POST['status']) {
    case "Отклонен":
        $nextStatus = "Конкурс";
        break;
    case "В обработке":
        $nextStatus = "Конкурс";
        break;
    case "Конкурс":
        $nextStatus = "Отклонен";
        break;
    default:
        $nextStatus = "В обработке";
}

$id_applicant = $_POST['ID_Applicant'];

$DB->updateApplicantStatus($id_applicant, $nextStatus);

?>