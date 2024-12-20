<?php

try {
    $db = new PDO('sqlite:files/database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Помилка підключення до бази даних: " . $e->getMessage());
}

$tableName = 'users'; 
$recordIndex = isset($_GET['record_index']) ? (int)$_GET['record_index'] : -1;
$fileContent = '';

if ($recordIndex >= 0) {
    
    $stmt = $db->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name=:tableName");
    $stmt->bindParam(':tableName', $tableName, PDO::PARAM_STR);
    $stmt->execute();
    $tableExists = $stmt->fetch();

    if ($tableExists) {
        
        $stmt = $db->prepare("SELECT * FROM $tableName LIMIT 1 OFFSET :offset");
        $stmt->bindParam(':offset', $recordIndex, PDO::PARAM_INT);
        $stmt->execute();
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                foreach ($_POST as $key => $value) {
                    if ($key !== 'record_index') {
                        
                        $stmtUpdate = $db->prepare("UPDATE $tableName SET $key = :value WHERE rowid = :recordIndex");
                        $stmtUpdate->bindParam(':value', $value);
                        $stmtUpdate->bindParam(':recordIndex', $recordIndex, PDO::PARAM_INT);
                        $stmtUpdate->execute();
                    }
                }
                $fileContent = "Запис успішно оновлено.";
                
                $stmt->execute();
                $record = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            $fileContent = "Запис не знайдений.";
        }
    } else {
        $fileContent = "Таблиця 'users' не знайдена.";
    }
} else {
    $fileContent = "Невірні параметри.";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагування запису</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Редагування запису</h1>
        <p><?php echo htmlspecialchars($fileContent); ?></p>

        <?php if (isset($record)): ?>
            <form method="POST">
                <h3>Редагування запису #<?php echo $recordIndex; ?></h3>
                <input type="hidden" name="record_index" value="<?php echo $recordIndex; ?>">

                <?php foreach ($record as $key => $value): ?>
                    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
                    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo htmlspecialchars($value); ?>" required>
                <?php endforeach; ?>

                <button type="submit">Зберегти зміни</button>
            </form>
        <?php endif; ?>

        <a href="select_file.php" class="btn-back">Повернутися до файлів</a>
    </div>
</body>
</html>
