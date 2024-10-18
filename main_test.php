<?php
session_start(); // Инициализация сессии

// Подключение к базе данных
$servername = "localhost:3301";
$usernameDB = "00ssadmin"; // Имя пользователя для базы данных
$password = "00ssadmin%";
$database = "database_shtk";
$conn = new mysqli($servername, $usernameDB, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Проверка, авторизован ли пользователь
if (!isset($_SESSION['username'])) {
    die("Вы не авторизованы. Пожалуйста, войдите в систему.");
}

// Получаем имя пользователя из сессии
$username = $_SESSION['username'];

// Получаем результаты тестов из базы данных
$sql = "SELECT test1_result, test2_result, test3_result, test4_result, test5_result FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($test1_result, $test2_result, $test3_result, $test4_result, $test5_result);
$stmt->fetch();
$stmt->close();

// Проверка, достаточно ли баллов в каждом тесте
if ($test1_result < 3 || $test2_result < 3 || $test3_result < 3 || $test4_result < 3 || $test5_result < 3) {
    die("Недостаточно баллов для доступа к итоговому тестированию. Убедитесь, что у вас не менее 3 баллов в каждом тесте.");
}

// Если доступ разрешен, выводим содержимое итогового теста
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Итоговое тестирование</title>
</head>
<body>
    <h1>Добро пожаловать на итоговое тестирование!</h1>
    <p>Результаты тестов:</p>
    <ul>
        <li>Тест 1: <strong><?php echo $test1_result; ?></strong> баллов</li>
        <li>Тест 2: <strong><?php echo $test2_result; ?></strong> баллов</li>
        <li>Тест 3: <strong><?php echo $test3_result; ?></strong> баллов</li>
        <li>Тест 4: <strong><?php echo $test4_result; ?></strong> баллов</li>
        <li>Тест 5: <strong><?php echo $test5_result; ?></strong> баллов</li>
    </ul>
    <p>Подготовьтесь к финальному тесту!</p>
    <!-- Здесь можно добавить содержимое итогового теста -->
</body>
</html>
