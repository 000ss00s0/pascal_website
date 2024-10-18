<?php
session_start(); // Начинаем сессию для работы с авторизацией пользователя
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Тесты</title>
    <link rel="stylesheet" href="tests_style.css">
</head>
<body>
<div class="container">
    <?php
    if (isset($_SESSION['username'])) {
        $role = $_SESSION['role']; // Получаем роль пользователя из сессии
        if ($role === 'teacher') {
            // Если роль учителя, перенаправляем на страницу для учителя с помощью JavaScript
            echo "<script>window.location.href = 'tests_teacher.html';</script>";
            exit();
        } else {
            // Иначе, открываем стандартную страницу тестов
            include 'tests.html';
        }
    } else {
        include 'auth.html';
    }
    ?>
</div>
</body>
</html>
