<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include '_menu.php'; ?>


    <h1>Kontakt</h1>

    <header class="text-center py-5">
        <div class="container">
            <h2>Wenn Sie Fragen haben, wenden Sie sich hier</h2>
            <p>Buchhandlung Siegl</p>
            <p>Landstraße 6</p>
            <p>4020 Linz</p>
            <p>Telefon: +43 (732) 30 49 44</p>
            <p>E-Mail: buchhandlungSiegl4020@gmail.com</p>

            <p id="info">Felder mit * müssen angegeben werden.</p>

            <form id="contactForm" action="#" method="get" style="color:brown;">
                <label for="fname">Vorname *</label><br>
                <input type="text" id="fname" name="fname" required><br>

                <label for="lname">Nachname *</label><br>
                <input type="text" id="lname" name="lname" required><br>

                <label for="email">E-Mail *</label><br>
                <input type="email" id="email" name="email" required><br>

                <label for="telefon">Telefon</label><br>
                <input type="tel" id="telefon" name="telefon"><br>

                <label for="nachricht">Nachricht *</label><br>
                <textarea id="nachricht" name="nachricht" required rows="4"></textarea> <br>

                <input type="submit" value="Absenden">
            </form>
        </div>
    </header>


    <footer class="bg-light text-center py-4">
        <div class="container">
            <a href="impressum.php">Impressum</a> | <a href="datenschutz.php">Datenschutz</a>
            <p class="mt-2">&copy; 2025 Buchhandlung Siegl</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>