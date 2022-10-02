<?php

//error_reporting(0);
session_start();


require_once "controllers/settings_controller.php";

require_once "controllers/filler.php";

require_once "controllers/validator_controller.php";

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
    <?php include "./components/mainNavbar.php"; ?>

    <?php

    if (!Setting::getClaimStatus()) {
        if (isset($_SESSION["frame"])) {
            switch ($_SESSION["frame"]) {
                case "1":
                    include "/Xampp/htdocs/components/secondForm.php";
                    break;
                case "2":
                    include "/Xampp/htdocs/components/thirdForm.php";
                    break;
                case "3":
                    echo file_get_contents("./components/doneClaimScreen.html");
                    $_SESSION["frame"] = "0";
                    break;
                default:
                    include "/Xampp/htdocs/components/mainForm.php";
            }
        } else {
            include "/Xampp/htdocs/components/mainForm.php";
        }
    } else {
        echo file_get_contents("./components/stopClaim.html");
    }

    ?>

    <?php include "./components/mainFooter.php"; ?>

    <script src="./bootstrap/bootstrap.js"></script>
</body>

</html>