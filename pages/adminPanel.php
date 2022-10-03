<?php


session_start();

require_once "../controllers/settings_controller.php";

if (!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("Location: ../index.php");
    exit();
}

$envStatus = Setting::getClaimStatus();


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
    <link rel="icon" type="icon/png" href="./images/decoration/school.png">
    <title>Подача заявки</title>
</head>

<body class="flex-column d-flex">
    <?php include "../components/mainNavbar.php"; ?>
    <main class="container d-flex flex-column algin-items-center justify-content-center">
        <div class="form-horizontal">
            <div class="form-group row d-flex flex-row div-bottom-mg">
                <label for="" class="col-sm-1 col-form-label">ФИО:</label>
                <div class="col-sm-3">
                    <input id="search_text" type="text" class="form-control" name="">
                </div>
                <div class="col-sm-1">
                    <buttion id="search_btn" type="button" class="btn btn-primary" value="Поиск">Поиск</buttion>
                </div>
                <div class="col-sm-1">
                    <buttion id="clear_btn" type="button" class="btn btn-primary" value="Очистить">Очистить</buttion>
                </div>
            </div>
            <table id="claims">
            </table>
        </div>

        <div class="p-5 mr-auto d-flex flex-row align-items-stretch">
            <form action="../actions/changeClaimStatus.php" method="POST">
                <input type="hidden" name="status" value="<?= $envStatus ? 0 : 1 ?>">
                <label for="">Статус набора: <?= $envStatus ? "закрыт" : "открыт" ?></label>
                <input type="submit" class="<?= $envStatus ? 'btn btn-success' : 'btn btn-danger' ?>" value="<?= $envStatus ? 'Открыть набор' : 'Закрыть набор' ?>" />
            </form>
        </div>
    </main>

    <?php include "../components/mainFooter.php"; ?>

    <script src="../bootstrap/bootstrap.js"></script>
    <script>
        $(document).ready(function() {
            grids = $('#claims').grid({
                primaryKey: 'ID_Applicant',
                dataSource: "/actions/getApplicantsForAdmin.php",
                //uiLibrary: "bootstrap",
                columns: [{
                        field: 'ID_Applicant',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'FIO',
                        sortable: true,
                        title: "ФИО"
                    },
                    {
                        field: 'GPA',
                        sortable: true,
                        title: "Средний балл",
                        type: "float"
                    },
                    {
                        field: 'status',
                        sortable: true,
                        title: "Статус",
                    },
                    {
                        title: 'Конкурс',
                        width: 250,
                        field: 'status',
                        type: 'text',
                        renderer: (value) => {
                            strForBtn = "";

                            switch (value) {
                                case "Отклонен":
                                    strForBtn = "Отправить на конкурс";
                                    break;
                                case "В обработке":
                                    strForBtn = "Отправить на конкурс";
                                    break;
                                case "Конкурс":
                                    strForBtn = "Cнять с конкурса";
                                    break;
                                default:
                                    strForBtn = "Cнять с конкурса";
                            }
                            return "<button class='btn btn-primary' style='white-space: nowrap; width: 184px;'>" + strForBtn + "</button>";
                        },
                        icon: 'glyphicon glyphicon-plus',
                        events: {
                            'click': updateStatus
                        }
                    },
                    {
                        title: 'Отклонить',
                        width: 250,
                        field: 'status',
                        type: 'text',
                        renderer: (value) => {
                            style = "";
                            if (value == "Отклонен") {
                                style = "disabled";
                            }

                            return "<button class='btn btn-danger' " + style + " style='white-space: nowrap; width: 184px;'>Отклонить</button>";
                        },
                        icon: 'glyphicon glyphicon-plus',
                        events: {
                            'click': updateStatusCancel
                        }
                    },
                ],
                pager: {
                    limit: 7,
                    sizes: false
                },
            });

            function updateStatusCancel(e) {
                if (e.data.record.status != "Отклонен") {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-Token': "{{ csrf_token() }}"
                        }
                    });
                    if (confirm('Вы уверены?')) {
                        var record = {
                            ID_Applicant: e.data.record.ID_Applicant,
                            status: "Конкурс",
                        };
                        $.ajax({
                            url: '/actions/updateStatusApplicant.php',
                            data: record,
                            method: 'POST'
                        })
                    }
                    grids.reload({
                        page: 1
                    });
                    grids.reload({
                        page: 1
                    });
                }
            };

            function updateStatus(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': "{{ csrf_token() }}"
                    }
                });
                if (confirm('Вы уверены?')) {
                    var record = {
                        ID_Applicant: e.data.record.ID_Applicant,
                        status: e.data.record.status,
                    };
                    $.ajax({
                        url: '/actions/updateStatusApplicant.php',
                        data: record,
                        method: 'POST'
                    })
                }
                grids.reload({
                    page: 1
                });
                grids.reload({
                    page: 1
                });
            };

            $("span:contains('Rows per page:')").css("display", "none");
            $("#search_btn").on('click', function() {
                grids.reload({
                    page: 1,
                    FIO: $('#search_text').val()
                });
            });
            $("#clear_btn").on('click', function() {
                $("#search_text").val('');
                grids.reload({
                    page: 1,
                    FIO: ''
                });
            });
        });
    </script>
</body>

</html>