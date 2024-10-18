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


    //
    //
    //    ВОТ ТУТ ДОБАВЛЯЕМ ВИЛКУ ПО РОЛЕ - СТУДЕНТ УЧИТЕЛЬ ИЛИ АДМИН
    //
    //
 if (isset($_SESSION['username'])) {
        $role = $_SESSION['role']; // Получаем роль пользователя из сессии
        if ($role === 'teacher') {
            // Если роль учителя, перенаправляем на страницу для учителя с помощью JavaScript
            echo "<script>window.location.href = 'PersonalAreaTeacher.html';</script>";
            exit();
        } elseif ($role === 'student') {
            // Если роль учителя, перенаправляем на страницу для студента с помощью JavaScript
            echo "<script>window.location.href = 'PersonalAreaStudent.html';</script>";
            exit();
        } elseif ($role === 'admin') {
            // Если роль учителя, перенаправляем на страницу для админа с помощью JavaScript
            echo "<script>window.location.href = 'PersonalAreaAdmin.php';</script>";
            exit();
        }
    } else {
        include 'auth.html';
    }

    // Проверяем, авторизован ли пользователь
//     if (isset($_SESSION['username'])) {
//         // Пользователь авторизован, выводим содержимое из готового HTML файла
//         include 'personal_area.html';
// //        echo "<p><a href='logout.php'>Выйти</a> из аккаунта.</p>";
//     } else {
//         include 'auth.html';
//     }
    ?>
</div>
</body>
</html>
