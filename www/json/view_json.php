<?php

$directory = 'files/';

if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {
        $fileContent = file_get_contents($filePath);
        $data = json_decode($fileContent, true);

        echo "<h3>Дані з файлу: $filename</h3>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    } else {
        echo "Файл не знайдений.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перегляд JSON-файлів</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Перегляд JSON-файлів</h1>

        <h3>Виберіть файл для перегляду:</h3>
        <form method="GET">
            <select name="filename">
                <?php
                $jsonFiles = glob($directory . '*.json');
                foreach ($jsonFiles as $file) {
                    $fileName = basename($file);
                    echo "<option value='$fileName'>$fileName</option>";
                }
                ?>
            </select>
            <button type="submit">Переглянути файл</button>
        </form>

        <a href="index.php">Повернутися на головну</a>
    </div>
</body>
</html>
