<?php
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tableName = $_POST['table_name'];
    $fields = $_POST['fields'];

    unset($fields['id']);

    $fields['created_at'] = date('Y-m-d H:i:s');

    $columns = implode(", ", array_keys($fields));
    $placeholders = ":" . implode(", :", array_keys($fields));

    try {
        $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($fields);
        echo "Запис додано в таблицю $tableName!";
    } catch (PDOException $e) {
        echo "Помилка при додаванні запису: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати запис</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Додавання нового запису</h1>
        <form method="POST">
            <label for="table_name">Виберіть таблицю:</label>
            <select name="table_name" id="table_name" onchange="getFields(this.value)">
                <option value="">Оберіть таблицю</option>
                <?php
                $stmt = $pdo->query("SHOW TABLES");
                while ($table = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $table['Tables_in_' . $dbname] . "'>" . $table['Tables_in_' . $dbname] . "</option>";
                }
                ?>
            </select><br>

            <div id="fields"></div>

            <button type="submit">Додати запис</button>
            <a href="index.php" class="btn-back">Повернутися на головну</a>
        </form>
    </div>

    <script>
        function getFields(table) {
            if (!table) {
                document.getElementById('fields').innerHTML = '';
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "get_columns.php?table=" + table, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var data = JSON.parse(xhr.responseText);
                    var fieldsHTML = '';
                    data.forEach(function(field) {
                        if (field !== 'id' && field !== 'created_at') {
                            fieldsHTML += '<label for="' + field + '">' + translateFieldName(field) + ':</label>';
                            fieldsHTML += '<input type="text" name="fields[' + field + ']" id="' + field + '" required><br>';
                        }
                    });
                    document.getElementById('fields').innerHTML = fieldsHTML;
                }
            };
            xhr.send();
        }

        function translateFieldName(field) {
            const translations = {
                'name': 'Назва',
            };

            return translations[field] || field;
        }
    </script>
</body>
</html>
