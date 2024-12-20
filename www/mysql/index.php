<?php
include('config.php');
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управління таблицями MySQL</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Управління таблицями MySQL</h1>
            <nav>
                <a href="create.php" class="btn">Створити нову таблицю</a><br><br>
                <a href="insert.php" class="btn">Додати новий запис</a><br><br>
                <a href="../index.php" class="btn-back">Повернутися на головну</a><br><br>
            </nav>
        </header>
        <main>
            <section>
                <h2>Список таблиць</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Назва таблиці</th>
                            <th>Кількість записів</th>
                            <th>Дії</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $pdo->query("SHOW TABLES");
                        while ($table = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $tableName = $table['Tables_in_' . $dbname];

                            $countStmt = $pdo->prepare("SELECT COUNT(*) FROM $tableName");
                            $countStmt->execute();
                            $count = $countStmt->fetchColumn();

                            echo "<tr>
                                    <td><a href='?table=" . urlencode($tableName) . "'>$tableName</a></td>
                                    <td>$count</td>
                                    <td>
                                        <a href='update.php?table=" . urlencode($tableName) . "'>Редагувати</a> |
                                        <a href='delete_table.php?table=" . urlencode($tableName) . "' onclick=\"return confirm('Ви впевнені, що хочете видалити таблицю $tableName?')\">Видалити</a>
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </section>

            <?php
            if (isset($_GET['table'])) {
                $tableName = $_GET['table'];
                try {
                    $stmt = $pdo->prepare("SELECT * FROM $tableName");
                    $stmt->execute();
                    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (count($records) > 0) {
                        echo "<section><h3>Записи таблиці $tableName</h3>";
                        echo "<table>";
                        echo "<thead><tr>";
                        foreach (array_keys($records[0]) as $column) {
                            echo "<th>" . htmlspecialchars($column) . "</th>";
                        }
                        echo "<th>Дії</th></tr></thead><tbody>";

                        foreach ($records as $record) {
                            echo "<tr>";
                            foreach ($record as $value) {
                                echo "<td>" . htmlspecialchars($value) . "</td>";
                            }
                            echo "<td>
                                    <a href='update.php?table=" . urlencode($tableName) . "&id=" . urlencode($record['id']) . "'>Редагувати</a> |
                                    <a href='delete.php?table=" . urlencode($tableName) . "&id=" . urlencode($record['id']) . "' onclick=\"return confirm('Ви впевнені, що хочете видалити цей запис?')\">Видалити</a>
                                  </td>
                                  </tr>";
                        }
                        echo "</tbody></table></section>";
                    } else {
                        echo "<p>У таблиці немає записів.</p>";
                    }
                } catch (PDOException $e) {
                    echo "Помилка при отриманні записів: " . $e->getMessage();
                }
            }
            ?>
        </main>
    </div>
</body>
</html>