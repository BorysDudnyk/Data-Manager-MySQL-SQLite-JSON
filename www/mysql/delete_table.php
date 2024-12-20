<?php
include('config.php');

if (isset($_GET['table'])) {
    $tableName = $_GET['table'];

    try {
        
        $sql = "DROP TABLE $tableName";
        $pdo->exec($sql);

        header("Location: index.php?message=Таблицю успішно видалено");
        exit;
    } catch (PDOException $e) {
        echo "Помилка при видаленні таблиці: " . $e->getMessage();
    }
} else {
    echo "Не вказано таблицю для видалення.";
    exit;
}
