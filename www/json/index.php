<?php

$directory = 'files/';

if (!is_dir($directory)) {
    mkdir($directory, 0777, true);
}

$jsonFiles = glob($directory . '*.json');
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управління JSON-файлами</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Управління JSON-файлами</h1>

        <a href="create_json.php" class="btn">Створити новий JSON-файл</a><br><br>
        <a href="add_record.php" class="btn">Додати новий запис</a><br><br>
        <a href="select_file.php" class="btn">Вибрати файл для перегляду</a><br><br>
        <a href="../index.php" class="btn-back">Повернутися на головну</a><br><br>

        <h3>Список JSON-файлів</h3>
        <?php if ($jsonFiles): ?>
            <table>
                <thead>
                    <tr>
                        <th>Назва файлу</th>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($jsonFiles as $file): 
                        $filename = basename($file);
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($filename); ?></td>
                            <td>
                                <a href="select_file.php?filename=<?php echo urlencode($filename); ?>" class="btn">Переглянути</a>
                                <a href="delete_file.php?filename=<?php echo urlencode($filename); ?>" class="btn-delete" onclick="return confirm('Ви впевнені, що хочете видалити цей файл?');">Видалити</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Немає доступних JSON-файлів.</p>
        <?php endif; ?>
    </div>
</body>
</html>
