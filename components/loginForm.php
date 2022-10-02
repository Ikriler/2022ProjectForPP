<main class="container d-flex flex-column align-items-center justify-content-center">
    <form action="/actions/login.php" class="form-horizontal col-sm-3 login-form" role="form" method="post">
    <p class="text-center fs-3">Вход</p>
    <div class="form-group row">
      <label for="login" class="col-form-label">Логин:</label>
      <div class="col-sm-12">
        <input type="text" class="form-control" name="login"/>
      </div>
    </div>
    <div class="form-group row" id="downpls">
      <label for="password" class="col-form-label">Пароль:</label>
      <div class="col-sm-12">
        <input type="password" class="form-control" name="password"/>
      </div>
      <?php
      
      if(isset($_SESSION['flash'])) {
        echo "<span class='error text-danger'>{$_SESSION['flash']}</span>";
        unset($_SESSION['flash']);
      }
      
      ?>
    </div>
    <div class="form-group row p-3">
        <div class="col-sm-12 d-flex flex-column align-items-center">
          <input type="submit" class="btn btn-primary col-sm-4" value="Войти"/>
        </div>
      </div>
  </form>
</main>