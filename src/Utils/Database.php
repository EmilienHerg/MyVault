<?php

namespace App\Utils;

use PDO;
use PDOException;

class Database
{
    private const HOST = 'localhost';
    private const DB_NAME = 'my_vault';
    private const USER = 'root';
    private const PASS = '';

    private static $pdoInstance = null;

    public static function getConnection(): PDO
    {
        if (self::$pdoInstance === null) {
            $dsn = "mysql:host=" . self::HOST . ";dbname=" . self::DB_NAME . ";charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            try {
                self::$pdoInstance = new PDO($dsn, self::USER, self::PASS, $options);
            } catch (PDOException $e) {
                throw new PDOException(
                    "Connexion BDD impossible : " . $e->getMessage(),
                    (int)$e->getCode()
                );
            }
        }

        return self::$pdoInstance;
    }
}
