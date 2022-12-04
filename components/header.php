<header>
    <div class="hcenter">
        <span class="hcenter-left">
            <a class="hlink" href="/">Главная страница</a>
            <a class="hlink" href="/info.php">О проекте</a>
        </span>
        <span class="hcenter-center">
            <img src="images/logo.png">
        </span>
        <span class="hcenter-right">
            <a class="hlink" href="/load.php">Загрузить таблицу</a>
            <?php
            if (isset($_SESSION['user'])) {
                echo('<a href="/php/logout.php">Выход</a>');
            } else {
                echo('<a href="/auth.php">Авторизация</a>');
            }
            ?>


        </span>
    </div>
</header>