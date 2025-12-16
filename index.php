<?php
session_start();
date_default_timezone_set('Europe/Vienna');
include 'db.php';

// Merkliste initialisieren
if (!isset($_SESSION['merkliste'])) {
    $_SESSION['merkliste'] = [];
}

// Kopie für Button-Farbprüfung
$merkliste = $_SESSION['merkliste'];

function existsInList($list, $value)
{
    return in_array($value, $list, true);
}


if (isset($_POST['merk_buch'])) {
    $buch = $_POST['merk_buch'];
    if (!existsInList($_SESSION['merkliste'], $buch)) {
        $_SESSION['merkliste'][] = $buch;
    }
}

// Öffnungszeiten aus DB
$stmt = $db->prepare("SELECT * FROM oeffnungszeiten WHERE weekday=?");
$stmt->execute([date('N')]); // 1=Montag ... 7=Sonntag
$today = $stmt->fetch(PDO::FETCH_ASSOC);

$geoeffnet = false;
$startStr = null;
$endeStr  = null;

if ($today) {
    if (!$today['closed'] && $today['opening_time'] && $today['closing_time']) {
        $startStr = $today['opening_time'];
        $endeStr  = $today['closing_time'];

        $start = strtotime(date('Y-m-d') . ' ' . $startStr);
        $ende  = strtotime(date('Y-m-d') . ' ' . $endeStr);
        $jetzt = time();

        $geoeffnet = ($jetzt >= $start && $jetzt <= $ende);
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
    <link rel="icon" href="pictures/favicon_buchhandlung.jpg">
</head>

<body>
    <?php include '_menu.php'; ?>

    <div class="container mt-5">
        <p>
         <?php if ($geoeffnet): ?>
    <div class="alert alert-success text-center">
        Wir haben geöffnet! (<?= htmlspecialchars($startStr) ?> - <?= htmlspecialchars($endeStr) ?>)
    </div>
<?php else: ?>
    <div class="alert alert-danger text-center">
        <?php if ($startStr && $endeStr): ?>
            Momentan geschlossen. Unsere Öffnungszeiten: <?= htmlspecialchars($startStr) ?> - <?= htmlspecialchars($endeStr) ?>
        <?php else: ?>
            Heute ganztägig geschlossen.
        <?php endif; ?>
    </div>
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
                        <img src="pictures/buchhandlung.jpg" class="d-block w-100 carousel-img" alt="Bild 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Bild 1</h5>
                            <p>Unser Äußeres.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="pictures/buchhandlung_wien.jpg" class="d-block w-100 carousel-img" alt="Bild 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Bild 2</h5>
                            <p>Unsere Inneneinrichtung</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="pictures/wiener_buchhandlung.jpg" class="d-block w-100 carousel-img" alt="Bild 3">
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
        <div class="mb-2">
            <label>E-Mail:</label>
            <input name="email" required>
        </div>
        <div class="mb-2">
            <label>Name:</label>
            <input name="fullName" required>
        </div>
        <div class="mb-2">
            <label>Adresse:</label>
            <input name="address" required>
        </div>
        <button type="submit">Anmelden</button>
    </form>

    <br>

    <?php
    if (isset($_POST['email'], $_POST['fullName'], $_POST['address'])) {
        $email = htmlspecialchars($_POST['email']);
        $name = htmlspecialchars($_POST['fullName']);
        $address = htmlspecialchars($_POST['address']);

        $stmt = $db->prepare("INSERT INTO newsletter (email, fullName, address) VALUES (?, ?, ?)");
        $stmt->execute([$email, $name, $address]);

        echo '<div class="alert alert-success">Danke, Ihre Anmeldung wurde erfolgreich gespeichert!</div>';
    }

    echo '<div class="text-center mt-3">
        <a style="font-weight: bold;" href="newsletter_list.php" class="btn btn-link">
            Bisherige Newsletter-Anmeldungen anzeigen
        </a>
      </div>';

    ?>
    <div class="container my-5">
        <h2 class="mb-4">Unsere Empfehlungen</h2>
        <div id="empfehlungKarussel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="pictures/Flag_of_Panem.svg" class="d-block w-100 carousel-img" alt="Buch 1">
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
                    <img src="pictures/garfield.jpg" class="d-block w-100 carousel-img" alt="Buch 2">
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
                    <img src="pictures/fairy_tail.avif" class="d-block w-100 carousel-img" alt="Buch 3">
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
    <script src="script.js"></script>

</body>

</html>