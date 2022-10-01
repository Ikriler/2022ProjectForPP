<?php
//echo $_SESSION['frameFirstData']['photoFace'];
?>

<main class="container d-flex flex-column align-items-center">
  <div class="display-4 p-4">Подача заявки на поступление</div>
  <form action="actions/goSecondForm.php" class="form-horizontal" role="form" id="mainframe" method="post" enctype="multipart/form-data" name="firstForm">
    <p class="text-center fs-3 p-1">Основная информация</p>
    <div class="form-group row d-flex flex-row align-items-right g-10">
      <label for="name" class="col-sm-1 col-form-label">Имя:</label>
      <div class="col-sm-3">
        <input type="text" name="name" class="form-control" value="<?= getFillOrEmptyString("name", "frameFirstData") ?>" />
      </div>
      <label for="surname" class="col-sm-1 col-form-label">Фамилия:</label>
      <div class="col-sm-3">
        <input type="text" name="surname" class="form-control" value="<?= getFillOrEmptyString("surname", "frameFirstData") ?>" />
      </div>
      <label for="patronymic" class="col-sm-1 col-form-label">Отчество:</label>
      <div class="col-sm-3">
        <input type="text" class="form-control" name="patronymic" value="<?= getFillOrEmptyString("patronymic", "frameFirstData") ?>" />
      </div>
    </div>
    <div class="form-group row">
      <label for="email" class="col-sm-1 col-form-label">Email:</label>
      <div class="col-sm-11">
        <input type="email" class="form-control" name="email" value="<?= getFillOrEmptyString("email", "frameFirstData") ?>" />
      </div>
    </div>
    <div class="form-group row">
      <label for="phone" class="col-sm-2 col-form-label">Номер телефона:</label>
      <div class="col-sm-10">
        <input type="tel" class="form-control" name="phone" value="<?= getFillOrEmptyString("phone", "frameFirstData") ?>" />
      </div>
    </div>
    <div class="form-group row">
      <label for="birthDay" class="col-sm-2 col-form-label">Дата рождения:</label>
      <div class="col-sm-10">
        <input type="date" class="form-control" name="birthDay" value="<?= getFillOrEmptyString("birthDay", "frameFirstData") ?>" />
      </div>
    </div>
    <div class="form-group row">
      <label for="sex" class="col-sm-2 col-form-label">Пол:</label>
      <div class="col-sm-10">
        <select name="sex" class="form-control">
          <option value="1">Мужской</option>
          <option value="0" <?= getFillOrEmptyString("sex", "frameFirstData") == 0 ? "selected" : "" ?>>Женский</option>
        </select>
      </div>
    </div>
    <!--Загрузка фото абитуриента-->
    <div class="form-group row">
      <label for="photoFace" class="col-sm-3 col-form-label">Фото абитуриента</label>
      <div class="col-sm-9">
        <input accept=".png,.jpg,.jpeg" class="form-control form-control-sm" id="formFileSm" type="file" name="photoFace" />
      </div>
    </div>
    <!--Конец загрузка фото абитуриента-->
    <!-- Личные достижения-->
    <p class="text-center fs-3 p-1">Личные достижения</p>
    <div class="form-group row d-flex flex-row align-items-center justify-content-center">
      <div class="col-sm-3">
        <input class="form-check-input" type="checkbox" value="1" name="goldGTO" id="flexCheckDefault1" <?= getFillOrEmptyString("goldGTO", "frameFirstData") == 1 ? "checked" : "" ?> />
        <label class="form-check-label" for="flexCheckDefault1">
          Золото ГТО
        </label>
      </div>
      <div class="col-sm-4">
        <input class="form-check-input" type="checkbox" value="1" name="winner" id="flexCheckDefault2" <?= getFillOrEmptyString("winner", "frameFirstData") == 1 ? "checked" : "" ?> />
        <label class="form-check-label" for="flexCheckDefault2">
          Призер/Победитель олимпиады
        </label>
      </div>
    </div>
    <!--Конец Личные достижения-->

    <div class="form-group d-flex flex-row align-items-right justify-content-end">
      <button id="" class="btn btn-primary col-sm-2" type="submit">
        Далее
      </button>
    </div>
  </form>

  <script></script>
</main>