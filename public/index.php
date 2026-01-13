<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\DashboardController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

echo "<h1>Mon Coffre-Fort Sécurisé</h1>";
echo $_ENV['DB_DATABASE'];

// A DECOMMENTER SI PB AVEC LA BDD
//
// try {
//     $db = Database::getConnection();
//     echo "Connexion à la BDD réussie.";
// } catch (\Throwable $e) {
//     die("Erreur BDD : " . $e->getMessage());
// }

$key = $_ENV['ENCRYPTION_KEY'];

if (!isset($key)) {
    die("Clé non définie.");
}

$url = $_SERVER['REQUEST_URI'];
$parse_url = parse_url($url, PHP_URL_PATH);

try {
    match (true) {
        str_ends_with($parse_url, '/register') => (new AuthController())->register(),
        str_ends_with($parse_url, '/login')    => (new AuthController())->login(),
        str_ends_with($parse_url, '/') || str_ends_with($parse_url, '/index.php') => header('Location: register') && exit,
        str_ends_with($parse_url, '/dashboard') => (new DashboardController())->index(),
        str_ends_with($parse_url, '/logout')    => (new DashboardController())->logout(),
        str_ends_with($parse_url, '/delete') => (new DashboardController())->delete(),

        default => throw new Exception("Page non trouvée"),
    };
} catch (Exception $e) {
    echo "<h1>Page 404</h1>";
}
