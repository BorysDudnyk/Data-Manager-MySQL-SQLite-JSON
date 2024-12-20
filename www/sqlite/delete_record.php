<?php

$directory = 'files/';

$filename = isset($_GET['filename']) ? basename($_GET['filename']) : '';
$fileContent = '';

if ($filename) {
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {
        
        $db = new SQLite3($filePath);

        $tableExists = $db->querySingle("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");

        if ($tableExists) {
            
            error_log("Таблиця 'users' існує. Видаляємо таблицю...");

            $db->exec("DROP TABLE users");

            if ($db->changes() > 0) {
                $fileContent = "Таблиця 'users' успішно видалена.";
            } else {
                
                error_log("Змінено рядків: " . $db->changes());
                $fileContent = "Запис успішно видалено.";
            }
        } else {
            
            error_log("Таблиця 'users' не знайдена в цьому файлі.");
            $fileContent = "Таблиця 'users' не знайдена в цьому файлі.";
        }
    } else {
        $fileContent = "Файл не знайдений.";
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
    <title>Видалення таблиці</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Результат видалення таблиці</h1>
        <p><?php echo htmlspecialchars($fileContent); ?></p>
        <a href="index.php" class="btn-back">Повернутися на головну</a>
    </div>
</body>
</html>
