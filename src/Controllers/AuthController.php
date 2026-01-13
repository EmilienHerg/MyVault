<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\Security;

class AuthController
{

    public function register()
    {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if ($token !== Security::getCsrfToken()) {
                die("Erreur de sécurité : Jeton CSRF invalide !");
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($email && !empty($password)) {

                $userModel = new User();

                if ($userModel->findByEmail($email)) {
                    $error = "Cet email est déjà utilisé.";
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    if ($userModel->create($email, $hash)) {
                        $success = "Compte créé avec succès !";
                    } else {
                        $error = "Erreur lors de la création du compte.";
                    }
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        require_once __DIR__ . '/../../templates/register.php';
    }

    public function login()
    {
        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            if ($token !== Security::getCsrfToken()) {
                die("Erreur de sécurité : Jeton CSRF invalide !");
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if ($email && $password) {
                $userModel = new \App\Models\User();

                $user = $userModel->findByEmail($email);

                if ($user && password_verify($password, $user['password_hash'])) {

                    \App\Utils\Security::login($user['id']);

                    header('Location: dashboard');
                    exit;
                } else {
                    $error = "Identifiants incorrects.";
                }
            } else {
                $error = "Veuillez remplir tous les champs.";
            }
        }

        require_once __DIR__ . '/../../templates/login.php';
    }
}
