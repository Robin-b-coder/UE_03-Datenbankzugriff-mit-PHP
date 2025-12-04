<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Standorte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="kaffee.jpg">
</head>

<body>

    <?php include '_menu.php'; ?>


    <h1>Standorte</h1>

    <header class="bg-transparent text-white text-center py-5">
        <div class="container">
            <h2>Das sind unsere Standorte</h2>
            <p> Wir haben 3 Standorte in ganz Österreich. Besuchen Sie uns in Linz, Wien oder Salzburg!
            </p>

            <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="buchhandlung_wien_draußen.jpg" class="d-block w-100 carousel-img" alt="Bild 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Unsere Hauptzentrale und die erste Buchhandlung von Siegl</h2>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Manga-Mafia_Store_Ulm_065142.jpg" class="d-block w-100 carousel-img" alt="Bild 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Die zweite Buchhandlung</h2>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="Höllrigl_Salzburg_1.jpg" class="d-block w-100 carousel-img" alt="Bild 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h2>Die dritte Filliale</h2>
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