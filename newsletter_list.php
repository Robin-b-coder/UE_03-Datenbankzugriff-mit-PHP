<?php
session_start();
include_once "db.php";


if (isset($_POST['form_action'])) {

    if ($_POST['form_action'] === "create") {
        $stmt = $db->prepare("INSERT INTO newsletter (email, fullName, address) VALUES (?, ?, ?)");
        $stmt->execute([$_POST['email'], $_POST['fullName'], $_POST['address']]);
    }

    if ($_POST['form_action'] === "update") {
        $stmt = $db->prepare("UPDATE newsletter SET email=?, fullName=?, address=? WHERE id=?");
        $stmt->execute([$_POST['email'], $_POST['fullName'], $_POST['address'], $_POST['id']]);
    }
}

if (isset($_POST['delete_id'])) {
    $stmt = $db->prepare("DELETE FROM newsletter WHERE id=?");
    $stmt->execute([$_POST['delete_id']]);
}

$rows = $db->query("SELECT * FROM newsletter ORDER BY id DESC")->fetchAll();
$editData = null;

if (isset($_POST['edit_id'])) {
    $stmt = $db->prepare("SELECT * FROM newsletter WHERE id=?");
    $stmt->execute([$_POST['edit_id']]);
    $editData = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Newsletter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="pictures/Newsletter_icon.png" type="image/x-icon">
</head>

<body>
    <?php include "_menu.php"; ?>
    <div class="container mt-5">

        <h1>Newsletter</h1>

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
                        <label>Email</label>
                        <input class="form-control" type="email" name="email"
                            value="<?= $editData['email'] ?? '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Name</label>
                        <input class="form-control" type="text" name="fullName"
                            value="<?= $editData['fullName'] ?? '' ?>">
                    </div>

                    <div class="mb-3">
                        <label>Adresse</label>
                        <input class="form-control" type="text" name="address"
                            value="<?= $editData['address'] ?? '' ?>">
                    </div>

                    <button class="btn btn-primary"><?= $editData ? "Speichern" : "Hinzufügen" ?></button>

                    <?php if ($editData): ?>
                        <a href="newsletter_list.php" class="btn btn-secondary">Abbrechen</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Email</th>
                    <th>Name</th>
                    <th>Adresse</th>
                    <th>Aktionen</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['fullName']) ?></td>
                        <td><?= htmlspecialchars($row['address']) ?></td>
                        <td>

                            <form method="post" style="display:inline;">
                                <input type="hidden" name="edit_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-warning btn-sm">Bearbeiten</button>
                            </form>

                            <form method="post" style="display:inline;" onsubmit="return confirm('Wirklich löschen?');">
                                <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                                <button class="btn btn-danger btn-sm">Löschen</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>