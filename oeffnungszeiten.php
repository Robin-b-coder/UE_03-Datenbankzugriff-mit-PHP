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
    'opening_time' => '',
    'closing_time' => ''
];

if (isset($_GET['edit'])) {
    $stmt = $db->prepare("SELECT * FROM oeffnungszeiten WHERE id=?");
    $stmt->execute([$_GET['edit']]);
    $editData = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['save'])) {
    $opening = $_POST['opening_time'];
    $closing = $_POST['closing_time'];

    if (!empty($_POST['id'])) {
        // Update
        $stmt = $db->prepare("UPDATE oeffnungszeiten SET opening_time=?, closing_time=? WHERE id=?");
        $stmt->execute([$opening, $closing, $_POST['id']]);

        $_SESSION['msg'] = "Eintrag aktualisiert!";
    } else {
        // Insert
        $stmt = $db->prepare("INSERT INTO oeffnungszeiten (opening_time, closing_time) VALUES (?, ?)");
        $stmt->execute([$opening, $closing]);

        $_SESSION['msg'] = "Eintrag hinzugefügt!";
    }

    header("Location: oeffnungszeiten.php");
    exit;
}

$stmt = $db->query("SELECT * FROM oeffnungszeiten ORDER BY id");
$list = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Öffnungszeiten</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<?php 
include_once '_menu.php';
?>
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
                    <label>Öffnungszeit</label>
                    <input type="time" class="form-control"
                           name="opening_time"
                           value="<?= $editData['opening_time'] ?>" required>
                </div>

                <div class="mb-3">
                    <label>Schlusszeit</label>
                    <input type="time" class="form-control"
                           name="closing_time"
                           value="<?= $editData['closing_time'] ?>" required>
                </div>

                <button class="btn btn-primary" name="save">Speichern</button>

                <?php if ($editData['id']): ?>
                    <a href="oeffnungszeiten.php" class="btn btn-secondary">Abbrechen</a>
                <?php endif; ?>

            </form>
        </div>
    </div>

      <h2>Alle Einträge</h2>

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Öffnet</th>
            <th>Schließt</th>
            <th>Aktion</th>
        </tr>

        <?php foreach ($list as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['opening_time'] ?></td>
                <td><?= $row['closing_time'] ?></td>
                <td>
                    <a href="oeffnungszeiten.php?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Bearbeiten</a>
                    <a href="oeffnungszeiten.php?delete=<?= $row['id'] ?>"
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