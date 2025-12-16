<?php
session_start();
include_once "db.php";

$message = $_SESSION['msg'] ?? "";
unset($_SESSION['msg']);

/* ---------------- DELETE ---------------- */
if (isset($_GET['delete'])) {
    $stmt = $db->prepare("DELETE FROM oeffnungszeiten WHERE id=?");
    $stmt->execute([$_GET['delete']]);

    $_SESSION['msg'] = "Eintrag gelöscht!";
    header("Location: oeffnungszeiten.php");
    exit;
}

/* ---------------- DEFAULT DATA ---------------- */
$editData = [
    'id' => '',
    'weekday' => '',
    'opening_time' => '',
    'closing_time' => '',
    'closed' => 0
];

/* ---------------- EDIT ---------------- */
if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM oeffnungszeiten WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* ---------------- SAVE ---------------- */
if (isset($_POST['save'])) {
    $weekday = $_POST['weekday'];
    $closed  = isset($_POST['closed']) ? 1 : 0;

    $opening = $closed ? null : $_POST['opening_time'];
    $closing = $closed ? null : $_POST['closing_time'];

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

/* ---------------- LIST ---------------- */
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
                            value="<?= $editData['opening_time'] ?>"
                            <?= $editData['closed'] ? 'disabled' : '' ?>>
                    </div>

                    <div class="mb-3">
                        <label>Schlusszeit</label>
                        <input type="time" class="form-control"
                            name="closing_time"
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

</body>

</html>