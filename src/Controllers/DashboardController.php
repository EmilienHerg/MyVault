<?php

namespace App\Controllers;

use App\Utils\Security;
use App\Utils\Crypto;
use App\Models\Secret;

class DashboardController
{

    public function index()
    {
        if (!Security::isLogged()) {
            header('Location: login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $secretModel = new Secret();
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if ($token !== Security::getCsrfToken()) {
                die("Erreur de sécurité : Jeton CSRF invalide !");
            }

            $title = $_POST['title'];
            $login = $_POST['login'];
            $rawPassword = $_POST['password'];

            $key = hex2bin($_ENV['ENCRYPTION_KEY']);

            if ($title && $rawPassword) {
                $encryptedPayload = Crypto::encrypt($rawPassword, $key);

                if ($secretModel->create($userId, $title, $login, $encryptedPayload)) {
                    $success = "Secret ajouté et chiffré avec succès !";
                } else {
                    $error = "Erreur lors de l'enregistrement.";
                }
            }
        }

        $secrets = $secretModel->getAllByUser($userId);
        require_once __DIR__ . '/../../templates/dashboard.php';
    }

    public function logout()
    {
        Security::logout();
        header('Location: login');
        exit;
    }

    public function delete()
    {
        if (!Security::isLogged()) header('Location: login') && exit;

        $id = $_GET['id'] ?? null;
        $userId = $_SESSION['user_id'];

        if ($id) {
            $secretModel = new Secret();
            $secretModel->delete((int)$id, $userId);
        }

        header('Location: dashboard');
        exit;
    }
}
