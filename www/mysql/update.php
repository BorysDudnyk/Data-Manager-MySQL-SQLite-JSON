<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $id = $_POST['id'];
    $tableName = $_POST['table_name'];

    try {
        $sql = "UPDATE $tableName SET name = :name WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array('name' => $name, 'id' => $id));
        echo "Запис успішно оновлено!";
    } catch (PDOException $e) {
        echo "Помилка при оновленні запису: " . $e->getMessage();
    }
}

if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = $_GET['id'];
    $tableName = $_GET['table'];

    $stmt = $pdo->prepare("SELECT * FROM $tableName WHERE id = :id");
    $stmt->execute(array('id' => $id));
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        $currentName = $record['name'];
    } else {
        echo "Запис не знайдений.";
    }
} else {
    echo "Невірні параметри для редагування.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати запис</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Редагувати запис</h1>

        <form method="POST">
            <input type="hidden" name="table_name" value="<?php echo htmlspecialchars($tableName); ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
            
            <label for="name">Назва:</label>
            <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($currentName); ?>" required><br>
            
            <button type="submit">Оновити</button>
        </form>

        <a href="index.php" class="btn-back">Повернутися на головну</a>
    </div>
</body>
</html>
