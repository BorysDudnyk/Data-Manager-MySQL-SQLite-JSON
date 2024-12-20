<?php

$directory = 'files/';

$filename = isset($_GET['filename']) ? $_GET['filename'] : '';
$recordIndex = isset($_GET['record_index']) ? $_GET['record_index'] : -1;
$fileContent = '';
$jsonData = array();

if ($filename && $recordIndex >= 0) {
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {
        
        $fileContent = file_get_contents($filePath);
        $jsonData = json_decode($fileContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $fileContent = "Не вдалося зчитати дані з файлу. Помилка: " . json_last_error_msg();
            $jsonData = array();
        } else {
            if (isset($jsonData[$recordIndex])) {
                $record = $jsonData[$recordIndex];
            } else {
                $fileContent = "Запис не знайдений.";
                $record = null;
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
    <title>Редагувати запис</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Редагування запису</h1>

        <a href="select_file.php" class="btn-back">Повернутися до файлів</a>

        <?php if (isset($record)): ?>
            <form method="POST" action="save_record.php">
                <h3>Редагування запису #<?php echo $recordIndex; ?></h3>
                <input type="hidden" name="filename" value="<?php echo htmlspecialchars($filename); ?>">
                <input type="hidden" name="record_index" value="<?php echo $recordIndex; ?>">

                <?php foreach ($record as $key => $value): ?>
                    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
                    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo htmlspecialchars($value); ?>" required>
                <?php endforeach; ?>

                <button type="submit">Зберегти зміни</button>
            </form>
        <?php else: ?>
            <p><?php echo $fileContent; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
