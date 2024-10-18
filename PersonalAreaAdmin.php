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

// Обработка действий
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST['action'];
    $username = $_POST['username'];
     
    if ($action === 'delete') {
        $sql = "DELETE FROM users WHERE username=?";
    } elseif ($action === 'block') {
        $sql = "UPDATE users SET status='blocked' WHERE username=?";
    } elseif ($action === 'unblock') {
        $sql = "UPDATE users SET status='active' WHERE username=?";
    } elseif ($action === 'reset') {
        $sql = "UPDATE users SET password='standartpassword' WHERE username=?";
    } elseif ($action === 'assignAdmin') {
        $sql = "UPDATE users SET role='admin' WHERE username=?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    exit();
}

// Запрос для получения данных
$sql = "SELECT username, email, role, status FROM users";
$result = $conn->query($sql);

// Начало HTML (include файла)
include 'PersonalAreaAdmin.html';

echo "<table>";
echo "<thead>
        <tr>
            <th>Имя пользователя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
      </thead>";

echo "<tbody>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr class='table-row'>
                <td class='table-cell'>" . htmlspecialchars($row['username']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['email']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['role']) . "</td>
                <td class='table-cell'>" . htmlspecialchars($row['status']) . "</td>
                <td class='table-cell'>
                    <button class='btn delete' onclick='performAction(\"delete\", \"" . $row['username'] . "\")'>Удалить</button>";

        // Если статус 'active', показываем кнопку для блокировки, иначе — для разблокировки
        if ($row['status'] === 'active') {
            echo "<button class='btn block' onclick='performAction(\"block\", \"" . $row['username'] . "\")'>Блокировать</button>";
        } elseif ($row['status'] === 'blocked') {
            echo "<button class='btn block' onclick='performAction(\"unblock\", \"" . $row['username'] . "\")'>Разблокировать</button>";
        }

        echo "  <button class='btn reset' onclick='performAction(\"reset\", \"" . $row['username'] . "\")'>Сбросить пароль</button>;
                <button class='btn assign' onclick='performAction(\"assignAdmin\", \"" . $row['username'] . "\")'>Назначить админом</button>
              </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>Нет данных</td></tr>";
}
echo "</tbody>";
echo "</table>";

// Закрытие соединения
$conn->close();
?>
