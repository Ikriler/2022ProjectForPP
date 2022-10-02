<?php

session_start();
require_once "../controllers/db_controller.php";

if(isset($_POST['login']) && isset($_POST['password'])) {
    if($DB->checkAuth($_POST['login'], $_POST['password'])) {
        $_SESSION['auth'] = true;
        header("Location: ../pages/adminPanel.php");
        exit();
    }   
    else {
        $_SESSION['flash'] = "Неправильный логин или пароль"; 
    }
}

header("Location: ../pages/loginPage.php");

?>