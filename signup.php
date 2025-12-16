<?php
session_start();
include_once 'db.php';

$message = "";

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Passwort-Validierung: mindestens 1 Groß-, 1 Kleinbuchstabe, 1 Sonderzeichen und 8 Zeichen lang
if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*\W).{8,}$/', $password)) {        $message = "Passwort muss mindestens einen Großbuchstaben, einen Kleinbuchstaben, eine Zahl, ein Sonderzeichen enthalten und mindestens 8 Zeichen lang sein!";
    } else {
        // prüfen, ob Benutzer existiert
        $stmt = $db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $message = "Benutzername existiert bereits!";
        } else {
            // Passwort hashen
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Benutzer speichern
            $stmt = $db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->execute([$username, $hashedPassword]);

            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            $message = "Registrierung erfolgreich!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <title>Registrieren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
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