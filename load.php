<?php
session_start();
require_once('php/connection.php');
$message = '';
if (isset($_POST["import"])) {
    if ($_FILES["database"]["name"] != '') {
        $array = explode(".", $_FILES["database"]["name"]);
        $extension = end($array);
        if ($extension == 'sql') {
            $output = '';
            $count = 0;
            $file_data = file($_FILES["database"]["tmp_name"]);
            foreach ($file_data as $row) {
                $start_character = substr(trim($row), 0, 2);
                if ($start_character != "--" && $start_character != "/*" && $start_character != "//" && $row != "") {
                    $output = $output . $row;
                    $end_character = substr(trim($row), -1, 1);
                    //echo ($end_character . "\r\n");
                    if ($end_character == ';') {
                        //echo ($output . "\r\n");
                        if (!mysqli_query($link, $output)) {
                            //echo ($output . "\r\n");
                            $count++;
                        }
                        $output = '';
                    }
                }
            }
            if ($count > 0) {
                //$message = '<label class="text-danger">There is an error in Database Import</label>';
            } else {
                //$message = '<label class="text-success">Database Successfully Imported</label>';
            }
        } else {
            //$message = '<label class="text-danger">Invalid File</label>';
        }
    } else {
        //$message = '<label class="text-danger">Please Select Sql File</label>';
    }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <title>Главная страница</title>
</head>

<body>
    <?php
    require('components/header.php');
    require_once('php/connection.php');
    $query = "SHOW TABLES";
    $result = mysqli_query($link, $query);
    $tables = $result->fetch_all();
    ?>

    <div class="container">
        <div class="load">
            <div class="load-left">
                <div class="load-left-name">Список таблиц в БД</div>
                <div class="load-left-list">
                    <?php
                    foreach ($tables as $table) {
                    ?>
                        <div class="load-left-list-row">
                            <span>• <?= $table[0] ?></span>
                            <?php
                            if (isset($_SESSION['user'])) {
                            ?>
                                <a href="/delete.php?tablename=<?= $table[0] ?>">Удалить</a>
                            <?php
                            }
                            ?>

                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="load-right">
                <div class="load-buttons">
                    <form method="post" enctype="multipart/form-data">
                        <input type="file" name="database" accept=".sql" />
                        <input type="submit" name="import" value="Вставить в БД" />
                    </form>
                </div>
                <?php echo $message . ' ';
                ?>
            </div>
        </div>
    </div>
    <?php
    $link->close();

    ?>
</body>