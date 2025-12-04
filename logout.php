<?php
session_start();
session_destroy();
setcookie("rememberme", "", time() - 3600); // Cookie löschen
header("Location: index.php");
exit;
