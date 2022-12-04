<?php session_start(); ?>
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
    <title>Главная страница</title>
</head>

<body>
    <?php
    require('components/header.php');
    ?>
    <div class="container">
        <div class="big-logo"><img src="images/biglogo.png"></div>
        <div class="info">
            <div class="info-name">Инструмент для оценки парных регрессионных моделей</div>
            <div class="info-main">
                <div class="info-main-left">
                    <div class="first-block">
                        <p>Цель проекта - создать удобный инструмент для оценки различных регрессионных моделей.</p>
                    </div>
                    <div class="second-block">
                        <p>Разработчики: <br>
                            • Александр Фаттахов<br>
                            • Владимир Селиванов<br>
                            • Максим Тепайкин<br>
                            • Артем Аверкин</p>
                    </div>
                </div>
                <div class="info-main-right">
                    <div class="third-block">
                        <p>
                            Используемые технологии: HTML, CSS, JavaScript, PHP, Chart.js и chartjs-plugin-regression.
                        </p>
                    </div>
                    <div class="fourth-block">
                        <p>Московский Политех<br>
                            Факультет информационных технологий<br>
                            Группа 191-341</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>