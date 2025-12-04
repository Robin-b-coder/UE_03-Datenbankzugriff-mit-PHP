<?php
session_start();
include_once 'db.php';

$message = "";
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // prüfen ob Benutzer existiert
    $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $message = "Benutzername existiert bereits!";
    } else {
        $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $message = "Registrierung erfolgreich!";
    }
}

/*$usersFile = __DIR__ . "/users.txt";
$message = "";

// Formular abgeschickt
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Benutzerliste laden
    $users = [];
    if (file_exists($usersFile)) {
        $lines = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($user,) = explode(";", $line);
            $users[$user] = true;
        }
    }

    // Prüfen, ob Benutzer existiert
    if (isset($users[$username])) {
        $message = "Benutzername existiert bereits!";
    } else {
        // Benutzer speichern
        file_put_contents($usersFile, "$username;$password\n", FILE_APPEND);
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        // Cookie setzen (angemeldet bleiben)
        setcookie("rememberme", $username, time() + (30*24*60*60)); // 30 Tage

        $message = "Registrierung erfolgreich! Du bist jetzt eingeloggt.";
    }
}*/ //gespeichert auf users.txt
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Registrieren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include "_menu.php"; ?>

    <div class="container mt-5" style="max-width: 400px;">
        <h2>Registrieren</h2>

        <?php if ($message): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Benutzername</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Passwort</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <button class="btn btn-primary" type="submit">Registrieren</button>
        </form>
    </div>

</body>

</html>