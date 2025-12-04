<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Öffnungszeiten laden
$zeiten = json_decode(file_get_contents(__DIR__ . '/oeffnungszeiten.json'), true);
$startStr = $zeiten['start'] ?? "08:00";
$endeStr  = $zeiten['ende'] ?? "18:00";

$heute = date('Y-m-d');
$start = strtotime("$heute $startStr");
$ende  = strtotime("$heute $endeStr");
$jetzt = time();

$geoeffnet = ($jetzt >= $start && $jetzt <= $ende);
?>

<nav id="mainNav" class="navbar navbar-expand-lg navbar-light bg-light sticky-nav">
    <div class="container">
        <a class="navbar-brand" href="index.php">Startseite</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item"><a class="nav-link" href="contact.php">Kontakt</a></li>

                <li class="nav-item"><a class="nav-link" href="standorte.php">Standorte</a></li>

                <!-- Café Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="cafeDropdown" role="button" data-bs-toggle="dropdown">
                        Das Café
                    </a>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="cafe.php">Über das Café</a></li>
                        <li><a class="dropdown-item" href="speisekarte.php">Speisekarte</a></li>
                        <li>
                            <a class="dropdown-item <?= $geoeffnet ? '' : 'disabled' ?>"
                                href="<?= $geoeffnet ? 'schnellbuchung.php' : '#' ?>">
                                Schnellbuchung
                            </a>
                        </li>
                    </ul>
                </li>

                <?php if (!empty($_SESSION['logged_in'])): ?>
                    <li class="nav-item"><a class="nav-link" href="newsletter_list.php">Newsletter</a></li>
                    <li class="nav-item"><a class="nav-link" href="oeffnungszeiten.php">Öffnungszeiten editieren</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout (<?= $_SESSION['username'] ?>)</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Anmelden</a></li>
                    <li class="nav-item"><a class="nav-link" href="signup.php">Registrieren</a></li>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="merkliste.php">Merkliste</a></li>
            </ul>
        </div>
    </div>
</nav>