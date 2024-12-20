<?php
include('config.php');

if (isset($_GET['table'])) {
    $table = $_GET['table'];
    $stmt = $pdo->prepare("DESCRIBE $table");
    $stmt->execute();
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo json_encode($columns);
}
?>
