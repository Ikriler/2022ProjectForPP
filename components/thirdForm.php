<?php


?>

<main class="container d-flex flex-column align-items-center">
  <div class="display-4 p-4">Подача заявки на поступление</div>
  <form action="actions/lastForm.php" class="form-horizontal col-sm-8" role="form" id="mainframe" method="POST" enctype="multipart/form-data">
    <p class="text-center fs-3 p-1">Аттестат</p>

    <div class="form-group row">
      <label for="at_number" class="col-sm-3 col-form-label">Номер аттестата:</label>
      <div class="col-sm-9">
        <input type="number" class="form-control" name="at_number" value="<?= getFillOrEmptyString("at_number", "frameThirdData") ?>" />
      </div>
      <span class="error text-danger"><?=getErrorMessage("at_number")?></span>
    </div>

    <div class="form-group row">
      <label for="at_date" class="col-sm-3 col-form-label">Дата выдачи:</label>
      <div class="col-sm-9">
        <input type="date" class="form-control" name="at_date" value="<?= getFillOrEmptyString("at_date", "frameThirdData") ?>" />
      </div>
      <span class="error text-danger"><?=getErrorMessage("at_date")?></span>
    </div>

    <div class="form-group row">
      <label for="at_name" class="col-sm-6 col-form-label">Название образовательного учреждения:</label>
      <div class="col-sm-6">
        <input type="text" class="form-control" name="at_name" value="<?= getFillOrEmptyString("at_name", "frameThirdData") ?>" />
      </div>
      <span class="error text-danger"><?=getErrorMessage("at_name")?></span>
    </div>

    <div class="form-group row">
      <label for="formFileSm1" class="col-sm-4 col-form-label">Скан аттестата</label>
      <div class="col-sm-8">
        <input class="form-control form-control-sm" id="formFileSm1" type="file" accept=".png,.jpg,.jpeg" name="at_scan" />
      </div>
      <span class="error text-danger"><?=getErrorMessage("at_scan")?></span>
    </div>

    <div class="form-group row">
      <label for="formFileSm2" class="col-sm-4 col-form-label">Скан приложения аттестата</label>
      <div class="col-sm-8">
        <input class="form-control form-control-sm" id="formFileSm2" type="file" accept=".png,.jpg,.jpeg" name="at_priloj_scan" />
      </div>
      <span class="error text-danger"><?=getErrorMessage("at_priloj_scan")?></span>
    </div>

    <div class="form-group row">
      <label for="middle_number" class="col-sm-2 col-form-label">Средний балл:</label>
      <div class="col-sm-10">
        <input type="number" step="0.01" class="form-control" name="middle_number" value="<?= getFillOrEmptyString("middle_number", "frameThirdData") ?>" />
      </div>
      <span class="error text-danger"><?=getErrorMessage("middle_number")?></span>
    </div>

    <div class="form-group row">
      <div class="checkselect">
        <label><input type="checkbox" name="spec[]" value="1" <?= checkSpecArrayOnChecked("1") ? "checked" : "" ?>>Информационные системы и программирование</label>
        <label><input type="checkbox" name="spec[]" value="2" <?= checkSpecArrayOnChecked("2") ? "checked" : "" ?>>Сетевое и системное администрирование</label>
        <label><input type="checkbox" name="spec[]" value="3" <?= checkSpecArrayOnChecked("3") ? "checked" : "" ?>>Компьютерные системы и комплексы</label>
      </div>
      <span class="error text-danger"><?=getErrorMessage("spec")?></span>
    </div>

    <div class="form-group d-flex flex-row align-items-center justify-content-center col-sm-12">
      <button id="" class="btn btn-primary col-sm-3" name="submit" value="back" type="submit">
        Назад
      </button>
      <div class="col-sm-6"></div>
      <button id="" class="btn btn-primary col-sm-3" name="submit" value="next" type="submit">
        Отправить зявку
      </button>
    </div>
  </form>
  <script src="https://snipp.ru/cdn/jquery/2.1.1/jquery.min.js"></script>
  <script src="../js/droplist.js"></script>
</main>