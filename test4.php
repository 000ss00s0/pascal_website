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

// Получаем ответы из формы
$q1Answer = $_POST['q1'];
$q2Answer = $_POST['q2'];
$q3Answer = $_POST['q3'];
$q4Answer = $_POST['q4'];
$q5Answer = $_POST['q5'];

// Задаем правильные ответы
$correctAnswers = array('4', '3', '1', '2', '3');

// Подсчитываем количество правильных ответов
$score = 0;
if ($q1Answer == $correctAnswers[0]) $score++;
if ($q2Answer == $correctAnswers[1]) $score++;
if ($q3Answer == $correctAnswers[2]) $score++;
if ($q4Answer == $correctAnswers[3]) $score++;
if ($q5Answer == $correctAnswers[4]) $score++;

// Получаем информацию о пользователе из сессии
$username = $_SESSION['username'];
$email = $_SESSION['email'];

// Проверка значений перед запросом (для отладки)
echo "Username: " . $username . "<br>";
echo "Email: " . $email . "<br>";
echo "Score: " . $score . "<br>";
//echo "Вы дали " . $score . " правильных ответов из 5" . "<br>";

// Подготовка SQL-запроса с использованием prepared statements
$sql = "UPDATE users SET test4_result = ? WHERE username = ? OR email = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Ошибка подготовки запроса: " . $conn->error);
}

// Привязываем параметры к запросу: "i" — для целого числа (score), "s" — для строк (username и email)
$stmt->bind_param("iss", $score, $username, $email);

// Выполняем запрос
if ($stmt->execute()) {
    echo "Результаты теста успешно записаны в базу данных";
} else {
    echo "Ошибка при записи результатов теста: " . $stmt->error;
}

// Закрываем подготовленный запрос и соединение
$stmt->close();
?>
