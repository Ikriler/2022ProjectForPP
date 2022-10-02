<?php


session_start();

require_once "../controllers/settings_controller.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap.css">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script src="js/jquery.ui.autocomplete.scroll.min.js" type="text/javascript"></script>
    <link rel="icon" type="icon/png" href="../images/decoration/school.png">
    <link rel="stylesheet" href="../css/index.css">


    <title>Списки</title>
</head>

<body class="flex-column d-flex">
    <?php include "../components/mainNavbar.php"; ?>
    <main class="container d-flex flex-column algin-items-center">

        <table id="claims">
        </table>

    </main>

    <?php include "../components/mainFooter.php"; ?>

    <script src="../bootstrap/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            grids = $('#claims').grid({
                primaryKey: 'ID_Applicant',
                dataSource: "/actions/getApplicants.php",
                columns: [{
                        field: 'ID_Applicant',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'Surname',
                        sortable: true,
                        title: "Фамилия"
                    },
                    {
                        field: 'Name',
                        sortable: true,
                        title: "Имя"
                    },
                    {
                        field: 'Patronymic',
                        sortable: true,
                        title: "Отчество"
                    },
                    {
                        field: 'GPA',
                        sortable: true,
                        title: "Средний балл",
                        type: "float"
                    },
                ],
                pager: {
                    limit: 15,
                    sizes: false
                },
            });
            $("span:contains('Rows per page:')").css("display", "none");
        });
    </script>
</body>

</html>