<?php
session_start();
include_once "db.php";

$message = $_SESSION['msg'] ?? "";
unset($_SESSION['msg']);

if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM oeffnungszeiten WHERE id=?");
    $stmt->execute([$_GET['delete']]);

    $_SESSION['msg'] = "Eintrag gelöscht!";
    header("Location: oeffnungszeiten.php");
    exit;
}

$editData = [
    'id' => '',
    'weekday' => '',
    'opening_time' => '',
    'closing_time' => '',
    'closed' => 0
];

if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM oeffnungszeiten WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['save'])) {
    $weekday = $_POST['weekday'];
    $closed  = isset($_POST['closed']) ? 1 : 0;

    // Standard: übernommene Werte aus Formular
    $opening = $_POST['opening_time'] ?? null;
    $closing = $_POST['closing_time'] ?? null;

    // Wenn geschlossen markiert, alte Werte beibehalten
    if ($closed && !empty($_POST['id'])) {
        $stmt = $db->prepare("SELECT opening_time, closing_time FROM oeffnungszeiten WHERE id=?");
        $stmt->execute([$_POST['id']]);
        $oldTimes = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($oldTimes) {
            $opening = $oldTimes['opening_time'];
            $closing = $oldTimes['closing_time'];
        }
    }

    if (!empty($_POST['id'])) {
        // UPDATE
        $stmt = $db->prepare("
            UPDATE oeffnungszeiten
            SET weekday=?, opening_time=?, closing_time=?, closed=?
            WHERE id=?
        ");
        $stmt->execute([$weekday, $opening, $closing, $closed, $_POST['id']]);
        $_SESSION['msg'] = "Eintrag aktualisiert!";
    } else {
        // INSERT
        $stmt = $db->prepare("
            INSERT INTO oeffnungszeiten (weekday, opening_time, closing_time, closed)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$weekday, $opening, $closing, $closed]);
        $_SESSION['msg'] = "Eintrag hinzugefügt!";
    }

    header("Location: oeffnungszeiten.php");
    exit;
}


$stmt = $db->query("SELECT * FROM oeffnungszeiten ORDER BY weekday");
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$days = [
    1 => 'Montag',
    2 => 'Dienstag',
    3 => 'Mittwoch',
    4 => 'Donnerstag',
    5 => 'Freitag',
    6 => 'Samstag',
    7 => 'Sonntag'
];
?>
<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <title>Öffnungszeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include_once '_menu.php'; ?>
    <br>

    <div class="container mt-5">

        <h1>Öffnungszeiten verwalten</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="card mb-4">
            <div class="card-header">
                <?= $editData['id'] ? "Eintrag bearbeiten" : "Neuen Eintrag hinzufügen" ?>
            </div>

            <div class="card-body">
                <form method="post">

    <input type="hidden" name="id" value="<?= $editData['id'] ?>">

    <div class="mb-3">
        <label>Wochentag</label>
        <select name="weekday" class="form-control" required>
            <option value="">Bitte wählen</option>
            <?php foreach ($days as $key => $day): ?>
                <option value="<?= $key ?>" <?= $editData['weekday'] == $key ? 'selected' : '' ?>>
                    <?= $day ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input" type="checkbox" name="closed" id="closed"
            <?= $editData['closed'] ? 'checked' : '' ?>>
        <label class="form-check-label" for="closed">
            Ganztägig geschlossen
        </label>
    </div>

    <div class="mb-3">
        <label>Öffnungszeit</label>
        <input type="time" class="form-control"
            name="opening_time"
            id="opening_time"
            value="<?= $editData['opening_time'] ?>"
            <?= $editData['closed'] ? 'disabled' : '' ?>>
    </div>

    <div class="mb-3">
        <label>Schlusszeit</label>
        <input type="time" class="form-control"
            name="closing_time"
            id="closing_time"
            value="<?= $editData['closing_time'] ?>"
            <?= $editData['closed'] ? 'disabled' : '' ?>>
    </div>

    <button class="btn btn-primary" name="save">Speichern</button>

    <?php if ($editData['id']): ?>
        <a href="oeffnungszeiten.php" class="btn btn-secondary">Abbrechen</a>
    <?php endif; ?>

</form>
            </div>
        </div>

        <h2>Alle Öffnungszeiten</h2>

        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Tag</th>
                <th>Zeiten</th>
                <th>Aktion</th>
            </tr>

            <?php foreach ($list as $row): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $days[$row['weekday']] ?></td>
                    <td>
                        <?php
                        if ($row['closed']) {
                            echo '<strong>Geschlossen</strong>';
                        } else {
                            echo $row['opening_time'] . ' - ' . $row['closing_time'];
                        }
                        ?>
                    </td>
                    <td>
                        <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Bearbeiten</a>
                        <a href="?delete=<?= $row['id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Sicher löschen?');">
                            Löschen
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    </div>

    <script>
document.addEventListener("DOMContentLoaded", function() {
    const closedCheckbox = document.getElementById("closed");
    const openingField = document.getElementById("opening_time");
    const closingField = document.getElementById("closing_time");

    closedCheckbox.addEventListener("change", function() {
        if (this.checked) {
            openingField.disabled = true;
            closingField.disabled = true;
        } else {
            openingField.disabled = false;
            closingField.disabled = false;
        }
    });
});
</script>

</body>

</html>