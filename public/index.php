<?php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Utils/Crypto.php';
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

echo "<h1>Mon Coffre-Fort Sécurisé</h1>";
echo "<p>Base de données connectée.</p>";

$key = $_ENV['ENCRYPTION_KEY'];

if (!isset($key)) {
    die("Clé non définie.");
}

$secret_text = "texte secret !";

$encrypted = Crypto::encrypt($secret_text, $key);
echo $encrypted;

$decrypted = Crypto::decrypt($encrypted, $key);
echo $decrypted;


