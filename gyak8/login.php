<?php

require 'utils/utils.php';

session_start();
if (isset($_SESSION['hId'])) {
    header('Location: index.php');
    exit();
}

$error = false;

if (isset($_POST['submit'])) {
    $error = true;
    if (!empty(trim($_POST['hId'])) && !empty(trim($_POST['password']))) {
        $hId = trim($_POST['hId']);
        $password = trim($_POST['password']);

        $users = load_data('data/users.json');

        foreach ($users as $user) {
            // A jelszavakat titkosítani kell, szóval itt is máshogy kell ellenőrizni a validitást
            if ($user['hId'] === $hId && $password === $user['password']) {
                $_SESSION['hId'] = $hId;
                header('Location: index.php');
                exit();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Bejelentkezés</title>
</head>
<body>
<main>
    <form method="POST" action="login.php">
        <label for="hId">h-s azonosító</label><br>
        <input type="text" id="hId" name="hId" required><br>
        <label for="password">Jelszó</label><br>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" name="submit" value="Bejelentkezés"><br>

        <?php if ($error) { ?>
            <img src="img/concierge_easter.webp" alt="kongerice">
        <?php } ?>
    </form>
    <a href="signup.php">Regisztráció</a>
</main>
</body>
</html>
