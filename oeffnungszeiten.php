<?php
include_once 'db.php';

$message = "";

// Öffnungszeiten laden
$stmt = $db->query("SELECT * FROM oeffnungszeiten ORDER BY id DESC LIMIT 1");
$editData = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$editData) {
    // Standardwerte, falls keine Daten vorhanden
    $editData = ['opening_time' => '08:00', 'closing_time' => '18:00', 'id' => null];
}

// Öffnungszeiten speichern
if (isset($_POST['opening_time'], $_POST['closing_time'])) {
    $opening_time = $_POST['opening_time'];
    $closing_time  = $_POST['closing_time'];

    if (!empty($_POST['id'])) {
        // Update
        $stmt = $db->prepare("UPDATE oeffnungszeiten SET opening_time=?, closing_time=? WHERE id=?");
        $stmt->execute([$opening_time, $closing_time, $_POST['id']]);
        $message = "Öffnungszeiten aktualisiert!";
    } else {
        // Neu anlegen
        $stmt = $db->prepare("INSERT INTO oeffnungszeiten (opening_time, closing_time) VALUES (?, ?)");
        $stmt->execute([$opening_time, $closing_time]);
        $message = "Öffnungszeiten hinzugefügt!";
        $_POST['id'] = $db->lastInsertId(); // neue ID für Maske
    }

    // Maske aktualisieren
    $editData['opening_time'] = $opening_time;
    $editData['closing_time'] = $closing_time;
    $editData['id'] = $_POST['id'];
}
?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Öffnungszeiten bearbeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include '_menu.php'; ?>
    <br>
    <div class="container mt-5">
        <h1>Öffnungszeiten bearbeiten</h1>

        <div class="card mb-4">
            <div class="card-header">
                <?= $editData['id'] ? "Eintrag bearbeiten" : "Neuen Eintrag anlegen" ?>
            </div>
            <div class="card-body">
                <form method="post">
                    <?php if ($editData['id']): ?>
                        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label>Öffnungszeit</label>
                        <input type="time" name="opening_time"
                            value="<?= htmlspecialchars($editData['opening_time']) ?>"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Schlusszeit</label>
                        <input type="time" name="closing_time"
                            value="<?= htmlspecialchars($editData['closing_time']) ?>"
                            class="form-control" required>
                    </div>

                    <button class="btn btn-primary"><?= $editData['id'] ? "Speichern" : "Hinzufügen" ?></button>
                    <?php if ($editData['id']): ?>
                        <a href="oeffnungszeiten.php" class="btn btn-secondary">Abbrechen</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
    </div>
</body>

</html>