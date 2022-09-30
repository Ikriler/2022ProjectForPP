<?php

session_start();


$_SESSION['auth'] = true;


header("Location: ../pages/adminPanel.php");

?>