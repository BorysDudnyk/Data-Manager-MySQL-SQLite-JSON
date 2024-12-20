<?php

$directory = 'files/';

$sqliteFiles = glob($directory . '*.db');

$sqliteData = array();
$fileContent = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['filename'])) {
    $filename = $_POST['filename'];
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {
        
        $db = new SQLite3($filePath);

        $tableExists = $db->querySingle("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");

        if ($tableExists) {
            
            $result = $db->query('SELECT * FROM users');

            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $sqliteData[] = $row;
            }

            if (empty($sqliteData)) {
                $fileContent = "Не вдалося зчитати дані з файлу.";
            }
        } else {
            $fileContent = "Таблиця 'users' не знайдена в цьому файлі.";
        }
    } else {
        $fileContent = "Файл не знайдений.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вибір файлу для перегляду</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Виберіть файл для перегляду</h1>

        <form method="POST">
            <label for="filename">Виберіть файл:</label>
            <select name="filename" id="filename" required>
                <?php
                if ($sqliteFiles) {
                    foreach ($sqliteFiles as $file) {
                        $filename = basename($file);
                        echo "<option value='$filename'>$filename</option>";
                    }
                } else {
                    echo "<option disabled>Немає доступних файлів</option>";
                }
                ?>
            </select>
            <button type="submit">Переглянути файл</button>
        </form>

        <a href="index.php" class="btn-back">Повернутися на головну</a>

        <?php if (!empty($sqliteData)): ?>
            <h3>Дані з файлу:</h3>
            <table>
                <thead>
                    <tr>
                        <?php
                        
                        foreach (array_keys($sqliteData[0]) as $key) {
                            echo "<th>" . htmlspecialchars($key) . "</th>";
                        }
                        ?>
                        <th>Дії</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    foreach ($sqliteData as $index => $row) {
                        echo "<tr>";
                        foreach ($row as $value) {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                        
                        echo "<td>
                            <a href='edit_record.php?filename=" . urlencode($_POST['filename']) . "&record_index=$index' class='btn-edit'>Редагувати</a>
                            <a href='delete_record.php?filename=" . urlencode($_POST['filename']) . "&record_index=$index' class='btn-delete'>Видалити</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php elseif (isset($fileContent)): ?>
            <p><?php echo $fileContent; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
