<?php

declare(strict_types=1);

require __DIR__ . '/auth.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (adminLogin($username, $password, $config)) {
        header('Location: index.php');
        exit;
    }

    $error = 'Login fehlgeschlagen.';
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<section class="page">
    <div class="container narrow">
        <h1>Admin Login</h1>
        <?php if ($error !== null): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post" class="contact-form">
            <label for="username">Benutzername</label>
            <input id="username" name="username" type="text" required>
            <label for="password">Passwort</label>
            <input id="password" name="password" type="password" required>
            <button type="submit" class="btn btn-primary">Einloggen</button>
        </form>
    </div>
</section>
</body>
</html>
