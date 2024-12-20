<?php
include('config.php');

if (isset($_GET['table']) && isset($_GET['id'])) {
    $tableName = $_GET['table'];
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM $tableName WHERE id = :id");

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Помилка при видаленні запису: " . $e->getMessage();
    }
} else {
    echo "Невірні параметри для видалення.";
    exit;
}
