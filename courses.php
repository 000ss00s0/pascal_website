<?php
session_start(); // Начинаем сессию для работы с авторизацией пользователя
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Курсы</title>
    <link rel="stylesheet" href="courses_style.css">
</head>
<body>
<div class="container">
    <?php
    if (isset($_SESSION['username'])) {
        // Пользователь авторизован, выводим содержимое из готового HTML файла
        include 'courses.html';
    } else {
        include 'auth.html';
    }
    ?>
</div>
</body>
</html>
