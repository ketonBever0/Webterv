<?php

require 'utils/utils.php';

// Ha a felhasználó nincs bejelentkezve kerüljön vissza a login.php-re

$error = false;

if (isset($_POST['submit'])) {
    $error = true;
    if (!empty(trim($_POST['content']))) {
        $content = trim($_POST['content']);

        // El kell menteni egy asszociatív tömbbe az adatokat, user kulcs alá a h-s azonosítót és content kulcs alá a
        // szöveget, majd beleíratni a data/messages.json fájlba a utils.php-ban szereplő függvény segítségével

        $error = false;
    }
}

// Be kell tölteni az összes üzenetet a data/messages.json fájlból, a utils.php segítségével
$messages = [];

?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Főoldal</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
<header>
    <span><?php echo $_SESSION['hId'] ?></span>
    <form method="POST" action="utils/logout.php">
        <input type="submit" name="submit" value="Kijelentkezés"><br>
    </form>
</header>
<main>
    <h1>Fórum</h1>
    <?php foreach ($messages as $message) {  ?>
        <div class="message">
            <p class="author"><?php echo $message['user'] ?></p>
            <p><?php echo $message['content'] ?></p>
        </div>
    <?php } ?>
    <form method="POST" action="index.php">
        <label for="content">Új üzenet</label><br>
        <textarea id="content" name="content"><?php if ($error) echo $_POST['content'] ?></textarea><br>
        <input type="submit" name="submit" value="Küldés">
    </form>
</main>
</body>
</html>
