<?php
// Подключение к базе данных
$servername = "localhost:3301";
$username = "00ssadmin";
$password = "00ssadmin%";
$database = "database_shtk";
$conn = new mysqli($servername, $username, $password, $database);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение данных из формы регистрации
$username = $_POST['username'];
$email = $_POST['email'];
$password = md5($_POST['password']); // Хеширование пароля с помощью MD5 перед сохранением в базе данных
$role = $_POST['role']; // Получаем выбранную роль

// Проверка занятости имени пользователя
$sql_check_username = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql_check_username);

if ($result->num_rows > 0) {
    // Если найдена хотя бы одна строка, значит имя пользователя уже занято
    $errorMessage = "Извините, это имя пользователя уже занято. Пожалуйста, выберите другое.";
    echo "<script>showError('$errorMessage');</script>";
} else {
    // Иначе, регистрируем пользователя в базе данных
    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

    if ($conn->query($sql) === TRUE) {
        // Регистрация успешна, перенаправляем пользователя на страницу личного кабинета
        session_start();
        $_SESSION['username'] = $username; // Сохраняем имя пользователя в сессии
        $_SESSION['role'] = $role; // где $role - роль пользователя
        echo "<script>window.location.href = 'personal_area.php';</script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Закрытие соединения с базой данных
$conn->close();

include 'register.html';
?>
