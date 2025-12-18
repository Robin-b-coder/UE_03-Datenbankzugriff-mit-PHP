<?php
include_once 'db.php';
// Öffnungszeiten einlesen
$heuteWochentag = date('N'); // 1=Montag ... 7=Sonntag
$stmt = $db->prepare("SELECT * FROM oeffnungszeiten WHERE weekday=?");
$stmt->execute([$heuteWochentag]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row && !$row['closed']) {
    $startStr = $row['opening_time'];
    $endeStr  = $row['closing_time'];
} else {
    die("Heute geschlossen. Die Schnellbuchung ist nur während der Öffnungszeiten möglich.");
}

$heute = date('Y-m-d');
$start = strtotime("$heute $startStr");
$ende  = strtotime("$heute $endeStr");
$jetzt = time();

// prüfen, ob geöffnet
$geoeffnet = ($jetzt >= $start && $jetzt <= $ende);

// Wenn geschlossen, weiterleiten oder Nachricht anzeigen
if (!$geoeffnet) {
    die("Momentan geschlossen. Die Schnellbuchung ist nur während der Öffnungszeiten möglich.");
}

// Formular absenden
$message = "";

include_once "db.php";

$message = "";
if (isset($_POST['name'], $_POST['anzahl'], $_POST['zeit'])) {
    $stmt = $db->prepare("INSERT INTO buchungen (name, anzahl, zeit) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], (int)$_POST['anzahl'], $_POST['zeit']]);
    $message = "Vielen Dank, " . htmlspecialchars($_POST['name']) . "! Ihre Schnellbuchung wurde angenommen.";
}
?>


?>

<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <title>Schnellbuchung</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>

    <?php include '_menu.php'; ?>


    <div class="container mt-5">
        <h1>Schnellbuchung</h1>

        <?php if ($message): ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>

        <form action="" method="post" class="mb-3">
            <div class="mb-2">
                <label class="form-label">Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Anzahl Personen:</label>
                <input type="number" name="anzahl" class="form-control" min="1" required>
            </div>
            <div class="mb-2">
                <label class="form-label">Gewünschte Zeit:</label>
                <input type="time" name="zeit" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Buchen</button>
        </form>

        <a href="menu.php" class="btn btn-secondary">Zurück zum Menü</a>
    </div>
</body>

</html>