<?php
session_start(); // Начинаем сессию, чтобы использовать переменные сессии
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Area</title>
    <link rel="stylesheet" href="personal_area.css">
</head>
<body>
<div class="container">
    <?php
    // Проверяем, авторизован ли пользователь
    if (isset($_SESSION['username'])) {
        // Пользователь авторизован, выводим содержимое из готового HTML файла
        include 'personal_area.html';
//        echo "<p><a href='logout.php'>Выйти</a> из аккаунта.</p>";
    } else {
        include 'auth.html';
    }
    ?>
</div>
</body>
</html>
