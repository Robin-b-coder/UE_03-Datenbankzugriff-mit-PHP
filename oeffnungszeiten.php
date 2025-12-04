<?php
// Öffnungszeiten einlesen
$zeiten = json_decode(file_get_contents(__DIR__ . '/oeffnungszeiten.json'), true);

// Standardwerte, falls JSON leer ist
$zeiten['start'] = $zeiten['start'] ?? "08:00";
$zeiten['ende']  = $zeiten['ende'] ?? "18:00";

$message = "";

// Öffnungszeiten aktualisieren
if (isset($_POST['start'], $_POST['ende'])) {
    $daten = [
        'start' => $_POST['start'],
        'ende'  => $_POST['ende']
    ];
    file_put_contents(__DIR__ . '/oeffnungszeiten.json', json_encode($daten));
    $message = "Öffnungszeiten aktualisiert!";
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
                <input type="time" name="start" value="<?= htmlspecialchars($zeiten['start']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Schlusszeit:</label>
                <input type="time" name="ende" value="<?= htmlspecialchars($zeiten['ende']) ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
            <a href="menu.php" class="btn btn-secondary">Zurück zum Menü</a>
        </form>
    </div>
</body>

</html>