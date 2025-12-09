<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Café</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="kaffee.jpg">
</head>

<body>

    <?php include '_menu.php'; ?>


<div class="container pt-4">
        <h1 class="mt-5">Das Café</h1>

    <h3> Bei Fragen / Reservierung rufen Sie die Nummer auf dieser Seite an </h3>
    <a href="contact.php">Zum Kontakt</a>
    <h3>Wenn Sie zur Speisekarte wollen gehen Sie hierhin</h3>
    <a href="speisekarte.php">Zur Speisekarte</a>

    <header class="bg-transparent text-white text-center py-5">
        <div class="container">
            <h3>Info</h3>
            <p>Das Café ist 2023 als Pilotenprojekt entstanden.</p>
            <p>Da wir dachten, es bietet den Besucher:innen der Buchhandlung die Möglichkeit, sich bei Kaffee und Kuchen
                zu
                entspannen und die gelesenen Bücher zu genießen.</p>
            <p>Als die Idee fertig gestellt wurde, bekamen wir viele Reservierungen. Und jetzt ist es ein fixer
                Bestandteil</p>
            </p>
            <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="Café_Hofburg_Wien_2008_Melange_1.jpg" class="d-block w-100 carousel-img" alt="Bild 1">
                        <div class="carousel-caption d-none d-md-block">
                            <p>Bild 1</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="café.jpg" class="d-block w-100 carousel-img" alt="Bild 2">
                        <div class="carousel-caption d-none d-md-block">
                            <p>Bild 2</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="pancake.jpg" class="d-block w-100 carousel-img" alt="Bild 3">
                        <div class="carousel-caption d-none d-md-block">
                            <p>Bild 3</p>
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
    <footer>
        <h2>Bitte beachten Sie, dass Reservierungen Vorrang haben</h2>
    </footer>

    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>


    <footer class="bg-light text-center py-4">
        <div class="container">
            <a href="impressum.php">Impressum</a> | <a href="datenschutz.php">Datenschutz</a>
            <p class="mt-2">&copy; 2025 Buchhandlung Siegl</p>
        </div>
    </footer>

    <!-- JS: Bootstrap, Sticky Nav, Search Filter -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>


</html>