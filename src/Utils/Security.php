<?php

namespace App\Utils;

class Security
{
    public static function safeSessionStart()
    {
        if (session_status() === PHP_SESSION_NONE) {

            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => '',
                'httponly' => true,
                'samesite' => 'Strict'
            ]);

            session_start();
        }
    }

    public static function login($userId)
    {
        self::safeSessionStart();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
    }

    public static function isLogged() {
        self::safeSessionStart();
        $isLogged = $_SESSION['user_id'];
        return $isLogged ? true : false;
    }


    public function logout() {
        self::safeSessionStart();
        session_unset();
        session_destroy();
    }

    public static function getCsrfToken(): string
    {
        self::safeSessionStart();

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}
