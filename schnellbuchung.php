<?php
include_once 'db.php';
// Öffnungszeiten einlesen
$zeiten = json_decode(file_get_contents(__DIR__ . '/oeffnungszeiten.json'), true);

// Zeiten für Vergleich
$startStr = $zeiten['start'] ?? "08:00";
$endeStr  = $zeiten['ende'] ?? "18:00";
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
/*if (isset($_POST['name'], $_POST['anzahl'], $_POST['zeit'])) {
    $name   = htmlspecialchars($_POST['name']);
    $anzahl = (int)$_POST['anzahl'];
    $zeit   = $_POST['zeit'];

    // gewünschte Zeit als Timestamp
    $buchungsZeit = strtotime("$heute $zeit");

    if ($buchungsZeit < $start || $buchungsZeit > $ende) {
        $message = "Die gewählte Zeit liegt außerhalb unserer Öffnungszeiten ($startStr - $endeStr).";
    } else {
        $line = "$name;$anzahl;$zeit\n";
        file_put_contents(__DIR__ . '/buchung.txt', $line, FILE_APPEND);
        $message = "Vielen Dank, $name! Ihre Schnellbuchung wurde angenommen";
    }
}*/ /*gespeichert auf buchung.txt*/


include_once "db.php";

$message = "";
if (isset($_POST['name'], $_POST['anzahl'], $_POST['zeit'])) {
    $stmt = $db->prepare("INSERT INTO buchungen (name, anzahl, zeit) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], (int)$_POST['anzahl'], $_POST['zeit']]);
    $message = "Vielen Dank, {$_POST['name']}! Ihre Schnellbuchung wurde angenommen.";
}
?>


?>

<!DOCTYPE html>
<html lang="de">

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>