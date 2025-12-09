<?php
session_start();
date_default_timezone_set('Europe/Vienna');

// Merkliste initialisieren
if (!isset($_SESSION['merkliste'])) {
    $_SESSION['merkliste'] = [];
}

// Kopie für Button-Farbprüfung
$merkliste = $_SESSION['merkliste'];

// Öffnungszeiten einlesen
$zeiten = json_decode(file_get_contents(__DIR__ . '/oeffnungszeiten.json'), true);

// Default-Werte
$startStr = $zeiten['start'] ?? "08:00";
$endeStr  = $zeiten['ende'] ?? "18:00";

// Heute als Datum + Zeit
$heute = date('Y-m-d');
$start = strtotime("$heute $startStr");
$ende  = strtotime("$heute $endeStr");
$jetzt  = time();

// prüfen, ob geöffnet
$geoeffnet = ($jetzt >= $start && $jetzt <= $ende);

// Nachricht für Anzeige
$message = $geoeffnet
    ? "Wir haben geöffnet! ($startStr - $endeStr)"
    : "Momentan geschlossen. Unsere Öffnungszeiten sind: $startStr - $endeStr (Mitteleuropäische Zeit)";

// Öffnungszeiten aktualisieren
if (isset($_POST['start'], $_POST['ende'])) {
    $daten = [
        'start' => $_POST['start'],
        'ende'  => $_POST['ende']
    ];
    file_put_contents(__DIR__ . '/oeffnungszeiten.json', json_encode($daten));
    $message = "Öffnungszeiten aktualisiert!";
    // Reload der Seite, um neuen Status zu sehen
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

function existsInList($list, $value)
{
    foreach ($list as $item) {
        if ($item === $value) {
            return true;
        }
    }
    return false;
}

if (isset($_POST['merk_buch'])) {
    $buch = $_POST['merk_buch'];
    if (!existsInList($_SESSION['merkliste'], $buch)) {
        $_SESSION['merkliste'][] = $buch;
    }
}

?>

<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buchhandlung Siegl</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./favicon_buchhandlung.jpg">
</head>

<body>
    <?php include '_menu.php'; ?>


    <?php
    include 'db.php';
    ?>

    <div class="container mt-3">
        <p>
            <?php if ($geoeffnet): ?>
                Wir haben geöffnet! (<?= htmlspecialchars($startStr) ?> - <?= htmlspecialchars($endeStr) ?>)
            <?php else: ?>
                Momentan geschlossen. Unsere Öffnungszeiten: <?= htmlspecialchars($startStr) ?> - <?= htmlspecialchars($endeStr) ?>
            <?php endif; ?>
        </p>
    </div>


    <h1>Willkommen bei Buchhandlung Siegl</h1>

    <header class="bg-transparent text-white text-center py-5">
        <div class="container">
            <p>Entdecken Sie eine große Auswahl an Büchern, E-Books und mehr. Ihr Partner für Literatur und Lesegenuss!
            </p>
            <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="buchhandlung.jpg" class="d-block w-100 carousel-img" alt="Bild 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Bild 1</h5>
                            <p>Unser Äußeres.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="buchhandlung_wien.jpg" class="d-block w-100 carousel-img" alt="Bild 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Bild 2</h5>
                            <p>Unsere Inneneinrichtung</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="wiener_buchhandlung.jpg" class="d-block w-100 carousel-img" alt="Bild 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Bild 3</h5>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
    </header>

    <H1>Newsletter </H1>


    <form id="mittig" action="" method="post">
        <label>E-Mail:
            <input name="email" required>
            <label>Name:
                <input name="fullName" required>
            </label>
            <label>Adresse:
                <input name="address" required>

            </label>
            <button type="submit">anmelden</button>
    </form>
    <br>

    <?php
    /* if (isset($_POST['email'], $_POST['fullName'], $_POST['address'])) {
        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['fullName']);
        $address = htmlspecialchars($_POST['address']);

        $line = "$email;$name;$address\n";
        file_put_contents(__DIR__ . '/email.txt', $line, FILE_APPEND);

        echo '<div class="alert alert-success">Danke, Ihre Anmeldung wurde erfolgreich gespeichert!</div>';
    }*/ //gespeichert auf email.txt Datei

    if (isset($_POST['email'], $_POST['fullName'], $_POST['address'])) {
        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['fullName']);
        $address = htmlspecialchars($_POST['address']);

        $stmt = $db->prepare("INSERT INTO newsletter (email, fullName, address) VALUES (?, ?, ?)");
        $stmt->execute([$email, $name, $address]);

        echo '<div class="alert alert-success">Danke, Ihre Anmeldung wurde erfolgreich gespeichert!</div>';
    }

    ?>

    <p><a href="newsletter_list.php">Bisherige Newsletter-Anmeldungen anzeigen</a></p>


    <div class="container my-5">
        <h2 class="mb-4">Unsere Empfehlungen</h2>
        <div id="empfehlungKarussel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="Flag_of_Panem.svg" class="d-block w-100 carousel-img" alt="Buch 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Buch 1</h5>
                        <p>Spannender Roman für den Sommer.</p>

                        <form method="post" style="display:inline;">
                            <input type="hidden" name="merk_buch" value="Tribute von Panem">
                            <button type="submit"
                                style="background:none; border:none; font-size:2rem; cursor: pointer;
            color: <?= existsInList($merkliste, 'Tribute von Panem') ? 'red' : 'gray' ?>;">
                                ❤️
                            </button>
                        </form>

                    </div>
                </div>
                <div class="carousel-item">
                    <img src="garfield.jpg" class="d-block w-100 carousel-img" alt="Buch 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Buch 2</h5>
                        <p>Lustige Comics.</p>

                        <form method="post" style="display:inline;">
                            <input type="hidden" name="merk_buch" value="Garfield">
                            <button type="submit"
                                style="background:none; border:none; font-size:2rem; cursor: pointer;
            color: <?= existsInList($merkliste, 'Garfield') ? 'red' : 'gray' ?>;">
                                ❤️
                            </button>
                        </form>

                    </div>
                </div>
                <div class="carousel-item">
                    <img src="fairy_tail.avif" class="d-block w-100 carousel-img" alt="Buch 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Buch 3</h5>
                        <p>Mangas.</p>

                        <form method="post" style="display:inline;">
                            <input type="hidden" name="merk_buch" value="Fairy Tail">
                            <button type="submit"
                                style="background:none; border:none; font-size:2rem; cursor: pointer;
            color: <?= existsInList($merkliste, 'Fairy Tail') ? 'red' : 'gray' ?>;">
                                ❤️
                            </button>
                        </form>

                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#empfehlungKarussel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#empfehlungKarussel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <div class="container my-5">
        <h2>Buchsuche</h2>
        <input type="text" id="searchInput" class="form-control mb-3" placeholder="Buchtitel suchen...">
        <ul id="bookList" class="list-group">
            <li class="list-group-item">Fairy Tail</li>
            <li class="list-group-item">Tribute von Panem</li>
            <li class="list-group-item">Garfield</li>
            <li class="list-group-item">The Saga of Tanya the Evil</li>
            <li class="list-group-item">Hägar</li>
        </ul>
    </div>

    <footer class="bg-light text-center py-4">
        <div class="container">
            <a href="impressum.php">Impressum</a> | <a href="datenschutz.php">Datenschutz</a>
            <p class="mt-2">&copy; 2025 Buchhandlung Siegl</p>
        </div>
    </footer>

    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

    <!-- JS: Bootstrap, Sticky Nav, Search Filter -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

</body>

</html>
<!-- Aufgabe 3: Sie benutzen bereits Session für den Login und jetzt sollen die Benutzerdaten in der Datenbank gespeichert werden(10 PKT). 
Für Passwörter sollten Sie Hashfunktionen verwenden(5 PKT).
Zusätzlich soll es auch möglich sein, dass sich User selbst einen Account anlegen und ein Passwort vergeben.(5 PKT)
Hinweis: Sie müssen nicht alle Anforderungen umsetzen. 
Die Hashfunktionen wurden im Unterricht nicht durchgenommen und Sie sollen sich diese bewusst im Selbststudium aneignen, 
um für eine volle Punktezahl die Anforderung etwas höher zu setzen.
Ziel: Umgang mit Logindaten und Hashfunktionen
-->