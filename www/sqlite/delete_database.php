<?php

$directory = 'files/';

$filename = isset($_GET['filename']) ? basename($_GET['filename']) : '';
$fileContent = '';

if ($filename) {
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {
        
        if (unlink($filePath)) {
            $fileContent = "Базу даних '$filename' успішно видалено.";
        } else {
            $fileContent = "Не вдалося видалити базу даних '$filename'.";
        }
    } else {
        $fileContent = "Файл '$filename' не знайдений.";
    }
} else {
    $fileContent = "Невірний параметр. Виберіть файл для видалення.";
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видалення бази даних</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Результат видалення бази даних</h1>
        <p><?php echo htmlspecialchars($fileContent); ?></p>
        <a href="index.php" class="btn-back">Повернутися на головну</a>
    </div>
</body>
</html>
