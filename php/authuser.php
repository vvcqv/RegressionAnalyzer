<?php
session_start();
require_once('connection.php');
if (isset($_POST['login'])) {
    $login = $_POST['login'];
}
if (isset($_POST['password'])) {
   $password = md5($_POST['password']);
}

$query = "SELECT * FROM `users` WHERE `login`='" . $login . "' AND `passw`='" . $password . "'";
$result = mysqli_query($link, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
}

if (isset($row)) {
    $_SESSION['message'] = 'Авторизация прошла успешно';
    $_SESSION['user'] = $row['login'];
} else {
    $_SESSION['message'] = 'Неверный логин или пароль';
}

header('Location: /auth.php');
