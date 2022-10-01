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
            data = [
                { 'ID': 1, 'Name': 'Hristo Stoichkov', 'PlaceOfBirth': 'Plovdiv, Bulgaria' },
                { 'ID': 2, 'Name': 'Ronaldo Luís Nazário de Lima', 'PlaceOfBirth': 'Rio de Janeiro, Brazil' },
                { 'ID': 3, 'Name': 'David Platt', 'PlaceOfBirth': 'Chadderton, Lancashire, England' },
                { 'ID': 4, 'Name': 'Manuel Neuer', 'PlaceOfBirth': 'Gelsenkirchen, West Germany' },
                { 'ID': 5, 'Name': 'James Rodríguez', 'PlaceOfBirth': 'Cúcuta, Colombia' },
                { 'ID': 6, 'Name': 'Dimitar Berbatov', 'PlaceOfBirth': 'Blagoevgrad, Bulgaria' }
            ];
        $(document).ready(function() {
            grids = $('#claims').grid({
                primaryKey: 'ID',
                dataSource: data,
                columns: [
                    { field: 'ID', width: 56 },
                    { field: 'Name', sortable: true },
                    { field: 'PlaceOfBirth', title: 'Place Of Birth', sortable: true },
                ],
                pager: {
                    limit: 5,
                    sizes: [2, 5, 10, 20]
                }
            });
        });
    </script>
</body>

</html>