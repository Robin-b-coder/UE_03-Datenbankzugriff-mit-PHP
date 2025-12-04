 <?php 
    $DB_HOST = "localhost"; //Host-Adresse
    $DB_NAME = "aufgabe"; //Datenbankname
    $DB_BENUTZER = "root"; //Benutzername
    $DB_PASSWORD = ""; // Passwort
$OPTION = [
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];


    try {
        $db = new PDO(
            "mysql:host=" . $DB_HOST . ";dbname=" . $DB_NAME,
            $DB_BENUTZER,
            $DB_PASSWORD,
            $OPTION
        );
    } catch (PDOException $e) {
        exit("Verbindung fehlgeschlagen! " . $e->getMessage());
    }
    ?>