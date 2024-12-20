<?php
if (isset($_GET['file'])) {
    $filePath = $_GET['file'];
    $db = new SQLite3($filePath);

    $results = $db->query("SELECT * FROM records");
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Перегляд SQLite-файлу</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Перегляд SQLite-файлу</h1>

    <h2>Записи:</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ім'я</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $results->fetchArray()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <h2>Додати новий запис</h2>
    <form action="add_record.php" method="POST">
        <input type="hidden" name="file" value="<?= htmlspecialchars($filePath) ?>">
        <label for="name">Ім'я:</label>
        <input type="text" name="name" id="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <button type="submit" name="add_record">Додати запис</button>
    </form>

    <a href="index.php">Повернутися до головної</a>
</body>
</html>
