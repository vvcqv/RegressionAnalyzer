<?php
require_once('php/connection.php');
if (isset($_GET['tablename'])) {
    $tablename = $_GET['tablename'];
}
$query = "DROP TABLE " . $tablename;
$result = mysqli_query($link, $query);
$link->close();
header('Location: /load.php');
