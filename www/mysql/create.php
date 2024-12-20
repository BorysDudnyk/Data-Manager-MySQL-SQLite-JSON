<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tableName = $_POST['table_name'];

    if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $tableName)) {
        echo "Невірне ім'я таблиці. Ім'я повинно починатися з літери або підкреслення і містити тільки літери, цифри та підкреслення.";
    } else {
        try {
            
            $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);

            $sql = "CREATE TABLE `$tableName` (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $pdo->exec($sql);
            echo "Таблиця $tableName створена!";
        } catch (PDOException $e) {
            echo "Помилка при створенні таблиці: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Створити таблицю</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Створення нової таблиці</h1>
        <form method="POST">
            <label for="table_name">Введіть назву таблиці:</label>
            <input type="text" name="table_name" id="table_name" required>
            <button type="submit">Створити таблицю</button>
            <a href="index.php" class="btn-back">Повернутися на головну</a>
        </form>
    </div>
</body>
</html>
