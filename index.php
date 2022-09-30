<?php


session_start();

require_once "controllers/settings_controller.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./bootstrap/bootstrap.css">
    <link rel="icon" type="icon/png" href="./images/decoration/school.png">
    <link rel="stylesheet" href="./css/index.css">
    <title>Подача заявки</title>
</head>

<body class="flex-column d-flex">
    <?php include "./components/mainNavbar.php";?>

    <?php 
    
    if(!Setting::getClaimStatus()) {
        echo file_get_contents("./components/mainForm.html");
    }
    else {
        echo file_get_contents("./components/stopClaim.html");
    }
    
    ?>

    <?php include "./components/mainFooter.php";?>

    <script src="./bootstrap/bootstrap.js"></script>
</body>

</html>