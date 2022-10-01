<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="navbar-collapse mr-auto">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="../index.php" class="nav-link">Подача заявкок</a>
            </li>
            <li class="nav-item">
                <a href="../pages/abilist.php" class="nav-link">Списки абитуриентов</a>
            </li>
            <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) : ?>
                <li class="nav-item">
                    <a href="../pages/adminPanel.php" class="nav-link">Админ панель</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) : ?>
        <form action="../actions/logout.php" class="my-2 my-sm-0" id="form_logout">
            <button class="btn btn-danger">Выйти</button>
        </form>
    <?php else: ?>
    <a href="../pages/loginPage.php"><button id="btn_login" class="btn btn-primary my-2 my-sm-0" type="submit">Войти</button></a>
    <?php endif;?>
</nav>