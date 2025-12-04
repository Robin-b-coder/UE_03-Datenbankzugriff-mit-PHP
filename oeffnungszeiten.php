<?php
include_once 'db.php';

$message = "";

// Öffnungszeiten laden
$stmt = $db->query("SELECT opening_time, closing_time FROM oeffnungszeiten LIMIT 1");
$zeiten = $stmt->fetch(PDO::FETCH_ASSOC);

// Falls keine Daten vorhanden, Standardwerte
if (!$zeiten) {
    $zeiten = ['opening_time' => '08:00', 'closing_time' => '18:00'];
}

// Öffnungszeiten speichern
if (isset($_POST['opening_time'], $_POST['closing_time'])) {
    $opening_time = $_POST['opening_time'];
    $closing_time  = $_POST['closing_time'];

    $stmt = $db->query("SELECT COUNT(*) FROM oeffnungszeiten");
    $exists = $stmt->fetchColumn();

    if ($exists) {
        $stmt = $db->prepare("UPDATE oeffnungszeiten SET opening_time = ?, closing_time = ? LIMIT 1");
        $stmt->execute([$opening_time, $closing_time]);
    } else {
        $stmt = $db->prepare("INSERT INTO oeffnungszeiten (opening_time, closing_time) VALUES (?, ?)");
        $stmt->execute([$opening_time, $closing_time]);
    }

    $message = "Öffnungszeiten aktualisiert!";
    $zeiten['opening_time'] = $opening_time;
    $zeiten['closing_time'] = $closing_time;
}
?>


<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Öffnungszeiten bearbeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php include '_menu.php'; ?>

    <div class="container mt-5">
        <h1>Öffnungszeiten bearbeiten</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Öffnungszeit:</label>
                <input type="time" name="opening_time" value="<?= htmlspecialchars($zeiten['opening_time']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Schlusszeit:</label>
                <input type="time" name="closing_time" value="<?= htmlspecialchars($zeiten['closing_time']) ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
            <a href="menu.php" class="btn btn-secondary">Zurück zum Menü</a>
        </form>
    </div>
</body>

</html>