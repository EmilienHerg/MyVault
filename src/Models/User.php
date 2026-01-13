<?php

namespace App\Models;

use App\Utils\Database;

class User
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function findByEmail(string $email)
    {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function create(string $email, string $passwordHash): bool
    {
        $query = "INSERT INTO users (email, password_hash) VALUES (:email, :password)";
        $stmt = $this->pdo->prepare($query);

        try {
            return $stmt->execute([
                ':email' => $email,
                ':password' => $passwordHash
            ]);
        } catch (\PDOException $error) {
            echo $error;
            return false;
        }
    }
}
