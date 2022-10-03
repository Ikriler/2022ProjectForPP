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
    <main class="container d-flex flex-column algin-items-center justify-content-center">
        <div class="from-horizontal abilist-form">
            <div class="p-3 d-flex flex-row">
                <div class="col-sm-8"></div>
                <span class="error text-success col-sm-2 text-center" id="budgetCount">Бюждетных мест: 1000</span>
                <span class="error text-warning col-sm-2 text-center" id="commercCount">Коммерческих мест: 1000</span>
            </div>
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
                <label for="" class="col-sm-2 col-form-label">Специальность:</label>
                <div class="form-group row col-sm-4">
                    <select name="" id="spec_select" class="form-control">
                        <option value="Информационные системы и программирование">Информационные системы и программирование</option>
                        <option value="Сетевое и системное администрирование">Сетевое и системное администрирование</option>
                        <option value="Компьютерные системы и комплексы">Компьютерные системы и комплексы</option>
                    </select>
                </div>
            </div>
            <table id="claims">
            </table>
        </div>

    </main>

    <?php include "../components/mainFooter.php"; ?>
    <script src="../js/droplist.js"></script>
    <script src="../bootstrap/bootstrap.js"></script>
    <script>
        var BudgetCount, CommetcCount;
        function getDataForSpec() {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '/actions/getDataSpec.php?spec=' + $("#spec_select").val(), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState != 4) {
                    return;
                }
                var Speciality = JSON.parse(xhr.responseText)

                BudgetCount = Speciality.Budget_Places_Count;
                CommetcCount = Speciality.NonBudget_Places_Count;

                $('#budgetCount').text("Бюждетных мест: " + BudgetCount);
                $('#commercCount').text("Коммерческих мест: " + CommetcCount);

                if (xhr.status === 200) {
                    console.log('result', xhr.responseText)
                } else {
                    console.log('err', xhr.responseText)
                }
            }
            xhr.send();
        }

        $(document).ready(function() {
            getDataForSpec();
            grids = $('#claims').grid({
                primaryKey: 'ID_Applicant',
                dataSource: "/actions/getApplicants.php",
                columns: [{
                        field: 'row_number',
                        title: "Место в конкурсе",
                        renderer: (value) => {
                            style = "text-warning";

                            if(value <= BudgetCount) {
                                style = "text-success";
                            }

                            if(value > CommetcCount) {
                                style = "text-danger";
                            }

                            return "<span class='error "+style+" text-center'>"+value+"</span>";
                        },
                    },
                    {
                        field: 'FIO',
                        title: "ФИО"
                    },
                    {
                        field: 'GPA',
                        title: "Средний балл",
                        type: "float"
                    },
                ],
                pager: {
                    limit: 7,
                    sizes: false
                },
            });
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
            $("#spec_select").on('change', function() {
                grids.reload({
                    page: 1,
                    spec: $("#spec_select").val()
                });
                getDataForSpec();
            });
        });
    </script>
</body>

</html>