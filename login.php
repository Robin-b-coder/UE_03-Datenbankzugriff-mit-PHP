<?php
session_start();
/*$usersFile = __DIR__ . "/users.txt";
$error = "";

// Cookie prüfen
if (!empty($_COOKIE['rememberme'])) {
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $_COOKIE['rememberme'];
    header("Location: index.php");
    exit;
}

// Login abgeschickt
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Benutzerliste laden
    $found = false;
    if (file_exists($usersFile)) {
        $lines = file($usersFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            list($user, $pw) = explode(";", $line);
            if ($user === $username && $pw === $password) {
                $found = true;
                break;
            }
        }
    }

    if ($found) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;

        // Cookie setzen
        setcookie("rememberme", $username, time() + (30*24*60*60)); // 30 Tage

        header("Location: index.php");
        exit;
    } else {
        $error = "Benutzername oder Passwort falsch!";
    }
}*/ /*gespeichert auf users.txt*/

include_once "db.php";

$error = "";
if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        $error = "Benutzername oder Passwort falsch!";
    }
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include "_menu.php"; ?>

    <div class="container mt-5" style="max-width: 400px;">
        <h2>Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
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

            <button class="btn btn-primary" type="submit">Anmelden</button>
        </form>
    </div>

</body>

</html>