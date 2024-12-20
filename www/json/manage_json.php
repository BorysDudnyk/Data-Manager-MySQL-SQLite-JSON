<?php

$directory = 'json/files/';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['filename'])) {
    $filename = $_POST['filename'] . '.json';
    $filepath = $directory . $filename;

    if (file_exists($filepath)) {
        echo "Файл з таким ім'ям вже існує. Спробуйте інше ім'я.";
    } else {
        if (file_put_contents($filepath, '[]')) {
            echo "Файл '$filename' успішно створено!";
        } else {
            echo "Не вдалося створити файл.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управління JSON файлами</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Управління JSON файлами</h1>

        <form method="POST">
            <label for="filename">Введіть ім'я файлу:</label>
            <input type="text" name="filename" id="filename" required>
            <button type="submit">Створити новий JSON файл</button>
        </form>

        <a href="index.php" class="btn-back">Повернутися на головну</a>
    </div>
</body>
</html>
