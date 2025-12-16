<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impressum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: lightgrey;
        }

        h1 {
            color: green;
            font-size: 3rem;
            /* größer */
            display: flex;
            justify-content: center;
            margin: 1rem 0;
        }

        h2 {
            color: blue;
            font-size: 2rem;
            /* größer */
            display: flex;
            justify-content: center;
            margin: 0.8rem 0;
        }

        p {
            color: black;
            font-weight: bold;
            font-size: 1.3rem;
            /* größer */
            margin: 0.3rem 0;
        }

        #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            border: none;
            background-color: red;
            color: white;
            cursor: pointer;
            padding: 15px;
            border-radius: 10px;
            font-size: 18px;
        }

        #myBtn:hover {
            background-color: #555;
        }
    </style>
</head>

<body>

    <?php include '_menu.php'; ?>


    <h1>Impressum</h1>

    <header class="text-center py-5">
        <div class="container">
            <h2>Niederlassung Linz</h2>
            <p>Buchhandlung Siegl</p>
            <p>Landstraße 6</p>
            <p>4020 Linz</p>
            <p>Telefon: +43 (732) 30 49 44</p>
            <p>E-Mail: buchhandlungSiegl4020@gmail.com</p>

            <h2>Niederlassung Wien</h2>
            <p>Mariahilfer straße 52</p>
            <p>1070 Wien</p>

            <h2>Niederlassung Salzburg</h2>
            <p>Getreidegasse 17</p>
            <p>5020 Salzburg</p>
        </div>
    </header>

    <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>

    <footer class="bg-light text-center py-4">
        <div class="container">
            <a href="#">Impressum</a> | <a href="datenschutz.php">Datenschutz</a>
            <p class="mt-2">&copy; 2025 Buchhandlung Siegl</p>
        </div>
    </footer>

</body>

</html>