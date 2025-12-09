<?php

$host = 'localhost'; // ou '127.0.0.1'
$db = 'my_vault';
$user = 'root'; // Par défaut sous Laragon
$pass = ''; // Par défaut vide sous Laragon (à changer si besoin)
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Indispensable pour voir les erreurs
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Plus pratique que fetch_row
    PDO::ATTR_EMULATE_PREPARES => false, // Sécurité : force les vrais Prepared Statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // echo "Connexion DB réussie !";
} catch (\PDOException $e) {
    die("Erreur de connexion BDD : " . $e->getMessage()); // En prod, on ne montre pas le message ! (on log)
}
