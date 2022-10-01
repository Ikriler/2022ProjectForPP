<?


?>

<main class="container d-flex flex-column align-items-center">
  <div class="display-4 p-4">Подача заявки на поступление</div>
  <form action="actions/goThirdForm.php" class="form-horizontal col-sm-8" role="form" id="mainframe" method="POST" enctype="multipart/form-data">
    <p class="text-center fs-3 p-1">Паспорт</p>

    <div class="form-group row d-flex flex-row align-items-right g-10">
      <label for="pass_seria" class="col-sm-2 col-form-label">Серия паспорта:</label>
      <div class="col-sm-3">
        <input type="number" class="form-control" name="pass_seria" value="<?= getFillOrEmptyString("pass_seria", "frameSecondData") ?>"/>
      </div>
      <label for="pass_number" class="col-sm-3 col-form-label">Номер паспорта:</label>
      <div class="col-sm-4">
        <input type="number" class="form-control" name="pass_number"  value="<?= getFillOrEmptyString("pass_number", "frameSecondData") ?>"/>
      </div>
    </div>

    <div class="form-group row">
      <label for="date_out" class="col-sm-2 col-form-label">Дата выдачи:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" name="date_out" value="<?= getFillOrEmptyString("date_out", "frameSecondData") ?>"/>
      </div>
    </div>

    <div class="form-group row">
      <label for="who_otdal" class="col-sm-2 col-form-label">Кем выдан:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="who_otdal" value="<?= getFillOrEmptyString("who_otdal", "frameSecondData") ?>"/>
      </div>
    </div>

    <div class="form-group row">
      <label for="podrazdel_number" class="col-sm-2 col-form-label">Номер подразделения:</label>
      <div class="col-sm-10">
        <input type="number" class="form-control" name="podrazdel_number" value="<?=getFillOrEmptyString("podrazdel_number", "frameSecondData") ?>"/>
      </div>
    </div>

    <div class="form-group row">
      <label for="formFileSm2" class="col-sm-3 col-form-label">Скан первого разворота</label>
      <div class="col-sm-9">
        <input class="form-control form-control-sm" id="formFileSm2" type="file" name="first_scan" accept=".png,.jpg,.jpeg"/>
      </div>
    </div>

    <div class="form-group row">
      <label for="formFileSm1" class="col-sm-3 col-form-label">Скан второго разворота</label>
      <div class="col-sm-9">
        <input class="form-control form-control-sm" id="formFileSm1" type="file" name="second_scan" accept=".png,.jpg,.jpeg"/>
      </div>
    </div>


    <div class="form-group d-flex flex-row align-items-center col-sm-12">
      <button id="" class="btn btn-primary col-sm-2" name="submit" value="back" type="submit">
        Назад
      </button>
      <div class="col-sm-8"></div>
      <button id="" class="btn btn-primary col-sm-2" name="submit" value="next" type="submit">
        Далее
      </button>
    </div>
  </form>
</main>