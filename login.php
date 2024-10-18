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

// Получение данных из формы входа
$username_or_email = $_POST['username'];
$password = md5($_POST['password']); // Пароль должен быть хеширован перед сравнением

// SQL-запрос для поиска пользователя в базе данных
$sql = "SELECT * FROM users WHERE (username='$username_or_email' OR email='$username_or_email') AND password='$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Пользователь найден, вход разрешен
    $user_data = $result->fetch_assoc(); // Получаем данные пользователя из результата запроса
    $role = $user_data['role']; // Извлекаем роль пользователя из данных

    // Запускаем сессию для сохранения состояния пользователя
    session_start();
    $_SESSION['username'] = $username_or_email; // Сохраняем имя пользователя в сессии
    $_SESSION['role'] = $role; // Сохраняем роль пользователя в сессии

    // Отправляем JSON ответ
    $response = array('success' => true);
    echo json_encode($response);
} else {
    // Пользователь не найден или пароль неверен
    // Отправляем JSON ответ с ошибкой
    $response = array('error' => 'Ваш ввод так уникален, что даже база данных не смогла его распознать. Попробуйте снова, но на этот раз придумайте что-то менее эксклюзивное!');
    echo json_encode($response);
}


// Закрытие соединения с базой данных
$conn->close();
?>
