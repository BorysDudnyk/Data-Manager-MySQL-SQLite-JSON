<?php
include('config.php');

if (isset($_GET['table'])) {
    $tableName = $_GET['table'];

    try {
        
        $stmt = $pdo->prepare("SELECT * FROM $tableName");
        $stmt->execute();
        $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Помилка при отриманні записів: " . $e->getMessage();
    }
} else {
    echo "Таблиця не вказана.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перегляд записів таблиці</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Перегляд записів таблиці: <?php echo htmlspecialchars($tableName); ?></h1>
        
        <?php if (count($records) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Назва</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['id']); ?></td>
                            <td><?php echo htmlspecialchars($record['name']); ?></td>
                            <td>
                                
                                <a href="update.php?table=<?php echo urlencode($tableName); ?>&id=<?php echo urlencode($record['id']); ?>">Редагувати</a> | 
                                <a href="delete.php?table=<?php echo urlencode($tableName); ?>&id=<?php echo urlencode($record['id']); ?>" onclick="return confirm('Ви впевнені, що хочете видалити цей запис?')">Видалити</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Немає записів у таблиці.</p>
        <?php endif; ?>

        <a href="index.php" class="btn-back">Повернутися на головну</a>
    </div>
</body>
</html>
