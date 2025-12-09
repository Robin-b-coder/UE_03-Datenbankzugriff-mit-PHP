<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Speisekarte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="./Speisekarte_Ausschnitt_im_Museumsstüberl.jpg">
</head>

<body>
    <?php include '_menu.php'; ?>

    <div class="container pt-4">
        <h1 class="mt-5">Die Speisekarte</h1>
        <header class="bg-transparent text-white text-center py-5">
            <div class="container">
                <p>Entdecken Sie eine große an Kaffee, Pancakes, Kuchen und mehr
                </p>
                <div id="bookCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="Speisekarte (1).jpg" class="d-block w-100 carousel-img" alt="Bild 1">
                            <div class="carousel-caption d-none d-md-block">
                                <p>Seite 1</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Speisekarte (2).jpg" class="d-block w-100 carousel-img" alt="Bild 2">
                            <div class="carousel-caption d-none d-md-block">
                                <p>Seite 2</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Speisekarte (3).jpg" class="d-block w-100 carousel-img" alt="Bild 3">
                            <div class="carousel-caption d-none d-md-block">
                                <p>Seite 3</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Speisekarte (4).jpg" class="d-block w-100 carousel-img" alt="Bild 3">
                            <div class="carousel-caption d-none d-md-block">
                                <p>Seite 4</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Speisekarte (5).jpg" class="d-block w-100 carousel-img" alt="Bild 3">
                            <div class="carousel-caption d-none d-md-block">
                                <p>Seite 5</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="Speisekarte (6).jpg" class="d-block w-100 carousel-img" alt="Bild 3">
                            <div class="carousel-caption d-none d-md-block">
                                <p>Seite 6</p>
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