<?php

// require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Utils/Crypto.php';
require_once __DIR__ . '/../src/Utils/Database.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/security.php';

use App\Controllers\AuthController;
use App\Utils\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

echo "<h1>Mon Coffre-Fort Sécurisé</h1>";

try {
    $db = Database::getConnection();
    echo "Connexion à la BDD réussie.";
} catch (\Throwable $e) {
    die("Erreur BDD : " . $e->getMessage());
}

// $key = $_ENV['ENCRYPTION_KEY'];

// if (!isset($key)) {
//     die("Clé non définie.");
// }

// $secret_text = "texte secret !";

// $encrypted = Crypto::encrypt($secret_text, $key);
// echo $encrypted;

// $decrypted = Crypto::decrypt($encrypted, $key);
// echo $decrypted;


$url = $_SERVER['REQUEST_URI'];
$parse_url = parse_url($url, PHP_URL_PATH);

try {
    match (true) {
        str_ends_with($parse_url, '/register') => (new AuthController())->register(),
        str_ends_with($parse_url, '/login')    => (new AuthController())->login(),
        str_ends_with($parse_url, '/') || str_ends_with($parse_url, '/index.php') => header('Location: register') && exit,
        // str_ends_with($uri, '/login') => (new AuthController())->login(),

        default => throw new Exception("Page non trouvée"),
    };
} catch (Exception $e) {
    echo "<h1>Page 404</h1>";
}
