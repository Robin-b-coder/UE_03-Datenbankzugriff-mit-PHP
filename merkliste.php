<?php
session_start();

// Löschen-Logik
if (isset($_POST['delete_buch'])) {
    $buch = $_POST['delete_buch'];
    $_SESSION['merkliste'] = array_filter($_SESSION['merkliste'], function ($item) use ($buch) {
        return $item !== $buch;
    });
}

// Kopie der Merkliste für Anzeige
$merkliste = $_SESSION['merkliste'] ?? [];
?>

<!DOCTYPE html>
<html lang="de-AT">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merkliste</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include '_menu.php'; ?>

    <div class="container mt-4">

        <br><br><br><br>
        <h1 class="display-4 mb-3">Meine Merkliste</h1>

        <?php
        if (!empty($merkliste)) {
            echo '<ul class="list-group">';
            foreach ($merkliste as $buch) {
                echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                echo htmlspecialchars($buch);
                echo '<form method="post" style="margin:0;">';
                echo '<input type="hidden" name="delete_buch" value="' . htmlspecialchars($buch) . '">';
                echo '<button class="btn btn-danger btn-sm">Löschen</button>';
                echo '</form>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p class="alert alert-info">Ihre Merkliste ist leer.</p>';
        }
        ?>
    </div>

</body>

</html>