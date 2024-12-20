<?php

$directory = 'files/';

$filename = isset($_GET['filename']) ? $_GET['filename'] : '';
$recordIndex = isset($_GET['record_index']) ? $_GET['record_index'] : -1;
$fileContent = '';

if ($filename && $recordIndex >= 0) {
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {
        
        $fileContent = file_get_contents($filePath);
        $jsonData = json_decode($fileContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $fileContent = "Не вдалося зчитати дані з файлу. Помилка: " . json_last_error_msg();
        } else {
            if (isset($jsonData[$recordIndex])) {
                unset($jsonData[$recordIndex]);
                $jsonData = array_values($jsonData);

                $jsonString = "[\n";
                foreach ($jsonData as $record) {
                    $jsonString .= "    {\n";
                    foreach ($record as $key => $value) {
                        $value = is_bool($value) ? ($value ? 'true' : 'false') : '"' . addslashes($value) . '"';
                        $jsonString .= "        \"$key\": $value,\n";
                    }
                    $jsonString = rtrim($jsonString, ",\n") . "\n    },\n";
                }
                $jsonString = rtrim($jsonString, ",\n") . "\n]";

                if (file_put_contents($filePath, $jsonString) === false) {
                    $fileContent = "Не вдалося видалити запис з файлу.";
                } else {
                    $fileContent = "Запис успішно видалено.";
                }
            } else {
                $fileContent = "Запис не знайдений.";
            }
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
    <title>Видалення запису</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Видалення запису</h1>
        <p><?php echo $fileContent; ?></p>
        <a href="select_file.php" class="btn-back">Повернутися до файлів</a>
    </div>
</body>
</html>
