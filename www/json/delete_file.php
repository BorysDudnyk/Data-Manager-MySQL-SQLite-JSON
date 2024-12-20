<?php

$directory = 'files/';

if (isset($_GET['filename'])) {
    $filename = basename($_GET['filename']);
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo "<p>Файл '$filename' успішно видалено.</p>";
        } else {
            echo "<p>Не вдалося видалити файл '$filename'.</p>";
        }
    } else {
        echo "<p>Файл не знайдений.</p>";
    }
} else {
    echo "<p>Не вказано файл для видалення.</p>";
}
?>

<a href="index.php">Повернутися на головну</a>
<link rel="stylesheet" href="../css/style.css">
