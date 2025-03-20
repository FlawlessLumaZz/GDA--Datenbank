<?php
$host = "localhost";
$dbname = "gda_datenbank";
$user = "root"; // Ändern, falls dein MySQL-User anders ist
$pass = ""; // Passwort hier eintragen, falls erforderlich

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}
?>
