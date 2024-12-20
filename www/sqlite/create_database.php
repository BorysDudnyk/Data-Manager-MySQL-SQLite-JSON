<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $databasePath = 'files/' . $_POST['database_name'] . '.db';

    if (file_exists($databasePath)) {
        $message = "Файл з таким ім'ям вже існує.";
    } else {
        
        $db = new SQLite3($databasePath);

        $db->exec("CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            email TEXT,
            name TEXT,
            given_name TEXT,
            family_name TEXT,
            nickname TEXT,
            last_ip TEXT,
            logins_count INTEGER,
            email_verified BOOLEAN
        )");

        $message = "Новий SQLite-файл успішно створений!";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Створити новий SQLite файл</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Створити новий SQLite файл</h1>

        <?php if (isset($message)): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>

        <form method="POST" action="create_database.php">
            <label for="database_name">Назва нового файлу:</label>
            <input type="text" id="database_name" name="database_name" required><br>

            <button type="submit">Створити SQLite файл</button>
        </form>

        <a href="index.php" class="btn-back">Повернутися на головну</a>
    </div>
</body>
</html>
