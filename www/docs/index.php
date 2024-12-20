<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Документація</title>
    <link rel="stylesheet" href="../css/index.css">
    <style>
        .hidden {
            display: none;
        }

        .section-title {
            cursor: pointer;
            color: #2980b9;
            text-decoration: underline;
        }

        .section-title:hover {
            color: #3498db;
        }
    </style>
</head>
<body>
    <header>
        <h1>Документація системи управління даними</h1>
    </header>
    <main class="content">
        <aside class="sidebar">
            <a href="../index.php" class="btn">На головну</a>
            <a href="../mysql/index.php" class="btn">MySQL</a>
            <a href="../json/index.php" class="btn">JSON</a>
            <a href="../sqlite/index.php" class="btn">SQLite</a>
        </aside>
        <section class="main-content">
            <h2>Документація</h2>
            <ul>
                <li><span class="section-title" data-target="about">Про систему</span></li>
                <li><span class="section-title" data-target="user-guide">Керівництво користувача</span></li>
                <li><span class="section-title" data-target="features">Ключові можливості</span></li>
                <li><span class="section-title" data-target="setup">Налаштування системи</span></li>
                <li><span class="section-title" data-target="faq">Часті запитання</span></li>
            </ul>

            <div id="about" class="hidden">
                <h3>Про систему</h3>
                <p>Ця система дозволяє працювати з різними джерелами даних, включаючи MySQL, JSON та SQLite. Вона створена для того, щоб забезпечити зручний інтерфейс роботи з базами даних і файлами.</p>
            </div>

            <div id="user-guide" class="hidden">
                <h3>Керівництво користувача</h3>
                <ul>
                    <li><strong>MySQL:</strong> Ви можете створювати, редагувати й видаляти таблиці та записи. Всі операції доступні через інтуїтивно зрозумілий інтерфейс.</li>
                    <li><strong>JSON:</strong> Робота з файлами JSON дозволяє швидко додавати, редагувати та переглядати дані в простому форматі.</li>
                    <li><strong>SQLite:</strong> Підходить для локальних проектів. Можна створювати бази даних, таблиці й працювати із записами.</li>
                </ul>
            </div>

            <div id="features" class="hidden">
                <h3>Ключові можливості</h3>
                <ul>
                    <li>Гнучке управління даними для різних форматів.</li>
                    <li>Інтуїтивно зрозумілий інтерфейс для адміністрування.</li>
                    <li>Швидке перемикання між різними джерелами даних.</li>
                    <li>Можливість роботи як з великими базами, так і з локальними файлами.</li>
                </ul>
            </div>

            <div id="setup" class="hidden">
                <h3>Налаштування системи</h3>
                <ul>
                    <li><strong>MySQL:</strong> Налаштуйте доступ до бази у файлі `config.php`, вказавши хост, користувача та пароль.</li>
                    <li><strong>JSON:</strong> Розмістіть файли у директорії `json/data/` та використовуйте інтерфейс для їх редагування.</li>
                    <li><strong>SQLite:</strong> Вкажіть шлях до файлу бази даних у конфігурації.</li>
                </ul>
            </div>

            <div id="faq" class="hidden">
                <h3>Часті запитання</h3>
                <ul>
                    <li><strong>Як створити нову таблицю в MySQL?</strong><br>Перейдіть до розділу MySQL і виберіть "Створити нову таблицю".</li>
                    <li><strong>Де розміщуються JSON-файли?</strong><br>Вони зберігаються у директорії `json/data/`.</li>
                    <li><strong>Чи можу я працювати з SQLite?</strong><br>Так, система повністю підтримує цей формат для локальних проектів.</li>
                </ul>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Управління даними. Всі права захищені.</p>
    </footer>
    <script>
        document.querySelectorAll('.section-title').forEach(function (title) {
            title.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                document.querySelectorAll('.main-content div').forEach(function (section) {
                    section.classList.add('hidden');
                });
                document.getElementById(targetId).classList.remove('hidden');
            });
        });
    </script>
</body>
</html>
