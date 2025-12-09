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

if (isset($_POST['form_action'])) {

    if ($_POST['form_action'] === "create") {
        $stmt = $db->prepare("INSERT INTO oeffnungszeiten (opening_time, closing_time) VALUES (?, ?)");
        $stmt->execute([$_POST['opening_time'], $_POST['closing_time']]);
    }

    if ($_POST['form_action'] === "update") {
        $stmt = $db->prepare("UPDATE oeffnungszeiten SET opening_time=?, closing_time=? WHERE id=?");
        $stmt->execute([$_POST['opening_time'], $_POST['closing_time'], $_POST['id']]);
    }
}

if (isset($_POST['delete_id'])) {
    $stmt = $db->prepare("DELETE FROM oeffnungszeiten WHERE id=?");
    $stmt->execute([$_POST['delete_id']]);
}

$rows = $db->query("SELECT * FROM oeffnungszeiten ORDER BY id DESC")->fetchAll();
$editData = null;

if (isset($_POST['edit_id'])) {
    $stmt = $db->prepare("SELECT * FROM oeffnungszeiten WHERE id=?");
    $stmt->execute([$_POST['edit_id']]);
    $editData = $stmt->fetch();
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
                <?= $editData ? "Eintrag bearbeiten" : "Neuen Eintrag anlegen" ?>
            </div>
            <div class="card-body">
                <form method="post">
                    <input type="hidden" name="form_action" value="<?= $editData ? 'update' : 'create' ?>">

                    <?php if ($editData): ?>
                        <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label>Öffnungszeit</label>
                        <input type="time" name="opening_time" value="<?= htmlspecialchars($zeiten['opening_time']) ?>" class="form-control" required>
                        <?= $editData['opening_time'] ?? '' ?>
                    </div>

                    <div class="mb-3">
                        <label>Schlusszeit</label>
                        <input type="time" name="closing_time" value="<?= htmlspecialchars($zeiten['closing_time']) ?>" class="form-control" required>
                        <?= $editData['closing_time'] ?? '' ?>
                    </div>

                    <button class="btn btn-primary"><?= $editData ? "Speichern" : "Hinzufügen" ?></button>

                    <?php if ($editData): ?>
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