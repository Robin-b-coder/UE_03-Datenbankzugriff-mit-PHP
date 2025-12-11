<?php
session_start();
include_once 'db.php';

$message = "";
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Klartext speichern

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