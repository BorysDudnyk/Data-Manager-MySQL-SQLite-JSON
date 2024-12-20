<?php
$directory = 'files/';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['filename'])) {
    $filename = $_POST['filename'];
    $filePath = $directory . $filename;

    if (file_exists($filePath)) {

        $db = new SQLite3($filePath);

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
            email_verified INTEGER
        )");

        $newRecord = array(
            'user_id' => (int)$_POST['user_id'],
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'given_name' => $_POST['given_name'],
            'family_name' => $_POST['family_name'],
            'nickname' => $_POST['nickname'],
            'last_ip' => $_POST['last_ip'],
            'logins_count' => (int)$_POST['logins_count'],
            'email_verified' => $_POST['email_verified'] === 'true' ? 1 : 0
        );

        $stmt = $db->prepare("INSERT INTO users (user_id, email, name, given_name, family_name, nickname, last_ip, logins_count, email_verified)
                              VALUES (:user_id, :email, :name, :given_name, :family_name, :nickname, :last_ip, :logins_count, :email_verified)");

        $stmt->bindValue(':user_id', $newRecord['user_id'], SQLITE3_INTEGER);
        $stmt->bindValue(':email', $newRecord['email'], SQLITE3_TEXT);
        $stmt->bindValue(':name', $newRecord['name'], SQLITE3_TEXT);
        $stmt->bindValue(':given_name', $newRecord['given_name'], SQLITE3_TEXT);
        $stmt->bindValue(':family_name', $newRecord['family_name'], SQLITE3_TEXT);
        $stmt->bindValue(':nickname', $newRecord['nickname'], SQLITE3_TEXT);
        $stmt->bindValue(':last_ip', $newRecord['last_ip'], SQLITE3_TEXT);
        $stmt->bindValue(':logins_count', $newRecord['logins_count'], SQLITE3_INTEGER);
        $stmt->bindValue(':email_verified', $newRecord['email_verified'], SQLITE3_INTEGER);

        $stmt->execute();

        $message = "Новий запис успішно додано.";
    } else {
        $message = "Файл не знайдений.";
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додавання нового запису</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Додавання нового запису</h1>

        <form method="POST">
            <label for="filename">Виберіть файл бази даних:</label><br>
            <select name="filename" id="filename" required>
                <?php
                $sqliteFiles = glob($directory . '*.db');
                if ($sqliteFiles) {
                    foreach ($sqliteFiles as $file) {
                        $filename = basename($file);
                        echo "<option value='$filename'>$filename</option>";
                    }
                } else {
                    echo "<option disabled>Немає доступних файлів</option>";
                }
                ?>
            </select><br><br>

            <label for="user_id">ID користувача:</label><br>
            <input type="text" name="user_id" id="user_id" required><br><br>

            <label for="email">Email:</label><br>
            <input type="email" name="email" id="email" required><br><br>

            <label for="name">Ім'я користувача:</label><br>
            <input type="text" name="name" id="name" required><br><br>

            <label for="given_name">Ім'я:</label><br>
            <input type="text" name="given_name" id="given_name" required><br><br>

            <label for="family_name">Прізвище:</label><br>
            <input type="text" name="family_name" id="family_name" required><br><br>

            <label for="nickname">Псевдонім:</label><br>
            <input type="text" name="nickname" id="nickname" required><br><br>

            <label for="last_ip">Останній IP:</label><br>
            <input type="text" name="last_ip" id="last_ip" required><br><br>

            <label for="logins_count">Кількість входів:</label><br>
            <input type="number" name="logins_count" id="logins_count" required><br><br>

            <label for="email_verified">Email підтверджено:</label><br>
            <select name="email_verified" id="email_verified" required>
                <option value="true">Так</option>
                <option value="false">Ні</option>
            </select><br><br>

            <button type="submit">Додати запис</button>
        </form>

        <?php
        if (isset($message)) {
            echo "<p>$message</p>";
        }
        ?>

        <a href="index.php">Повернутися на головну</a>
    </div>
</body>
</html>
