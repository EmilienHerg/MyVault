<?php

namespace App\Models;

use App\Utils\Database;

class Secret
{

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAllByUser(int $userId): array
    {
        $query = "SELECT * FROM secrets WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':user_id' => $userId]);

        return $stmt->fetchAll();
    }

    public function create(int $userId, string $title, string $login, string $encryptedPassword): bool
    {
        $query = "INSERT INTO secrets (user_id, title, login, encrypted_password) 
                VALUES (:user_id, :title, :login, :password)";
        $stmt = $this->pdo->prepare($query);

        return $stmt->execute([
            ':user_id' => $userId,
            ':title' => $title,
            ':login' => $login,
            ':password' => $encryptedPassword
        ]);
    }

    public function delete(int $secretId, int $userId): bool
    {
        $sql = "DELETE FROM secrets WHERE id = :id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $secretId, ':user_id' => $userId]);
    }
}
