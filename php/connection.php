<?php
$host = 'localhost';  //  имя  хоста
$db   = 'id18250631_std_1532_prbd'; // имя бд
$user = 'id18250631_std_1532'; //имя пользователя
$pass = 'changed311A!'; //пароль к бд
$charset = 'utf8'; //кодировка юникод (поддерживает кирилицу)

$link = mysqli_connect($host, $user, $pass, $db);
// if (!$link) {
//     echo "Ошибка: Невозможно установить соединение с MySQL.";
//     echo "Код ошибки errno: " . mysqli_connect_errno();
//     echo "Текст ошибки error: " . mysqli_connect_error();
// }

if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}
