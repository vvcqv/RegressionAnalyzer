<?php session_start();
if (isset($_SESSION['user'])) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="manifest" href="images/site.webmanifest">
    <title>Авторизация</title>
</head>

<body>
    <?php
    require('components/header.php');
    require_once('php/connection.php');
    ?>
    <div class="auth-title">Авторизация</div>
    <form action="/php/authuser.php" method="post" style="text-align: center;">
        <input type="text" name="login" placeholder=" Логин" class="auth" required><br><br>
        <input type="password" name="password" placeholder=" Пароль" class="auth" required><br><br>
        <input type="submit" value="Войти">
        <?php
        if (isset($_SESSION['message'])) {
            echo ('
            <p style="color:green;">
            ' . $_SESSION['message'] . '
            </p>
            ');
            unset($_SESSION['message']);
        }
        ?>
    </form>



</body>

</html>