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
    <div id="yes" style="width: 100px; height:100px;"></div>
    <!--Start image checker  -->
    <div id="image_dialog" class="gj-display-none">
        <div data-role="body" id="image_place" style="height: 100%;">

        </div>
    </div>
    <!--End image checker-->
    <!-- Start float form -->
    <div id="dialog" class="gj-display-none">
        <div data-role="body">
            <input type="hidden" id="ID" />
            <div class="form-row">
                <label for="d_email" class="col-sm-4 col-form-label">Email:</label>
                <div class="col-sm-8">
                    <input type="text" readonly class="form-control-plaintext" id="d_email" value="email@example.com">
                </div>
            </div>
            <div class="form-row">
                <label for="d_phone" class="col-sm-4 col-form-label">Телефон:</label>
                <div class="col-sm-8">
                    <input type="text" readonly class="form-control-plaintext" id="d_phone" value="email@example.com">
                </div>
            </div>
            <div class="form-row">
                <input type="hidden" id="d_photo_applicant_hide_href" />
                <label for="d_photo_applicant" class="col-sm-4 col-form-label">Фото абитуриента:</label>
                <div class="col-sm-8">
                    <input type="button" class="btn btn-info" style="color:white;" id="d_photo_applicant" value="Посмотреть фото">
                </div>
            </div>
            <div class="form-row">
                <input type="hidden" id="d_photo_first_scan_hide_href" />
                <label for="d_photo_first_scan" class="col-sm-4 col-form-label">Первый скан паспорта:</label>
                <div class="col-sm-8">
                    <input type="button" class="btn btn-info" style="color:white;" id="d_photo_first_scan" value="Посмотреть фото">
                </div>
            </div>
            <div class="form-row">
                <input type="hidden" id="d_photo_second_scan_hide_href" />
                <label for="d_photo_second_scan" class="col-sm-4 col-form-label">Второй скан паспорта:</label>
                <div class="col-sm-8">
                    <input type="button" class="btn btn-info" style="color:white;" id="d_photo_second_scan" value="Посмотреть фото">
                </div>
            </div>
            <input type="hidden" id="d_photo_at_scan_hide_href" />
            <div class="form-row">
                <label for="d_photo_at" class="col-sm-4 col-form-label">Скан аттестата:</label>
                <div class="col-sm-8">
                    <input type="button" class="btn btn-info" style="color:white;" id="d_photo_at" value="Посмотреть фото">
                </div>
            </div>
            <div class="form-row">
                <input type="hidden" id="d_photo_add_at_hide_href" />
                <label for="d_photo_add_at" class="col-sm-4 col-form-label">Скан приложения аттестата:</label>
                <div class="col-sm-8">
                    <input type="button" class="btn btn-info" style="color:white;" id="d_photo_add_at" value="Посмотреть фото">
                </div>
            </div>
        </div>
    </div>
    <!-- End float form -->

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
                        field: 'Email',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'Phone_Number',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'Photo',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'Scan_Certificate',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'Scan_Аpplication_Certificate',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'Scan_First_Passport',
                        width: 56,
                        hidden: true
                    },
                    {
                        field: 'Scan_Second_Passport',
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
                    {
                        title: 'Подробнее',
                        width: 250,
                        field: 'status',
                        type: 'text',
                        renderer: (value) => {
                            return "<button class='btn btn-info' style='white-space: nowrap; color:white; width: 184px;'>Подробнее</button>";
                        },
                        icon: 'glyphicon glyphicon-plus',
                        events: {
                            'click': showDialog
                        }
                    },
                ],
                pager: {
                    limit: 7,
                    sizes: false
                },
            });

            dialog = $('#dialog').dialog({
                autoOpen: false,
                resizable: false,
                modal: true,
                width: 500,
                height: 600
            });

            image_dialog = $('#image_dialog').dialog({
                autoOpen: false,
                resizable: true,
                modal: true,
                width: 600,
                height: 600
            });
            function showDialog(e) {
                $("#d_email").val(e.data.record.Email);
                $("#d_phone").val(e.data.record.Phone_Number);
                $("#d_photo_applicant_hide_href").val(e.data.record.Photo);
                $("#d_photo_first_scan_hide_href").val(e.data.record.Scan_First_Passport);
                $("#d_photo_second_scan_hide_href").val(e.data.record.Scan_Second_Passport);
                $("#d_photo_at_scan_hide_href").val(e.data.record.Scan_Certificate);
                $("#d_photo_add_at_hide_href").val(e.data.record.Scan_Аpplication_Certificate);
                dialog.open("Подробная информация");
            }

            //photo_applicant
            $("#d_photo_applicant").on("click", function() {
                $href = $("#d_photo_applicant_hide_href").val().replace("D:/Xampp/htdocs", "..");
                $("#image_place").css("background-image", "url(" + $href + ")");
                $("#image_place").css("background-size", "contain");
                $("#image_place").css("background-repeat", "no-repeat");
                $("#image_place").css("background-position", "center");
                image_dialog.open("Фото абитуриента");
            });
            //photo_first_scan
            $("#d_photo_first_scan").on("click", function() {
                $href = $("#d_photo_first_scan_hide_href").val().replace("D:/Xampp/htdocs", "..");
                $("#image_place").css("background-image", "url(" + $href + ")");
                $("#image_place").css("background-size", "contain");
                $("#image_place").css("background-repeat", "no-repeat");
                $("#image_place").css("background-position", "center");
                image_dialog.open("Первый скан пасспорта");
            });
            //photo_second_scan
            $("#d_photo_second_scan").on("click", function() {
                $href = $("#d_photo_second_scan_hide_href").val().replace("D:/Xampp/htdocs", "..");
                $("#image_place").css("background-image", "url(" + $href + ")");
                $("#image_place").css("background-size", "contain");
                $("#image_place").css("background-repeat", "no-repeat");
                $("#image_place").css("background-position", "center");
                image_dialog.open("Второй скан пасспорта");
            });
            //photo_scan_at
            $("#d_photo_at").on("click", function() {
                $href = $("#d_photo_at_scan_hide_href").val().replace("D:/Xampp/htdocs", "..");
                $("#image_place").css("background-image", "url(" + $href + ")");
                $("#image_place").css("background-size", "contain");
                $("#image_place").css("background-repeat", "no-repeat");
                $("#image_place").css("background-position", "center");
                image_dialog.open("Скан аттестата");
            });
            //photo_add_at
            $("#d_photo_add_at").on("click", function() {
                $href = $("#d_photo_add_at_hide_href").val().replace("D:/Xampp/htdocs", "..");
                $("#image_place").css("background-image", "url(" + $href + ")");
                $("#image_place").css("background-size", "contain");
                $("#image_place").css("background-repeat", "no-repeat");
                $("#image_place").css("background-position", "center");
                image_dialog.open("Скан приложения аттестата");
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