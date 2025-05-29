<?php

namespace App\Models;

class User extends Model
{
    public function create($name, $email, $password)
    {
        // Validate name (basic example)
        if (empty($name) || strlen($name) > 100) {
            throw new \InvalidArgumentException('Invalid name');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email format');
        }

        // Additional validation for email length and domain
        if (strlen($email) > 254) {
            throw new \InvalidArgumentException('Email is too long');
        }

        $domain = substr(strrchr($email, "@"), 1);
        if (!checkdnsrr($domain, 'MX')) {
            throw new \InvalidArgumentException('Invalid email domain');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = self::$pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPassword]);

        $userId = self::$pdo->lastInsertId();

        // Insert default settings for the new user
        $stmtSettings = self::$pdo->prepare("INSERT INTO user_settings (user_id, notifications, dark_mode, privacy_mode) VALUES (?, ?, ?, ?)");
        // default: notifications=1 (true), dark_mode=0 (false), privacy_mode=0 (false)
        $stmtSettings->execute([$userId, 1, 0, 0]);

        return $this->findById($userId);
    }   

    public function findByEmail($email)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateStatusAbout($userId, $status, $about)
    {
        $sql = "UPDATE users SET status = :status, about = :about WHERE id = :id";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':about' => $about,
            ':id' => $userId
        ]);
    }
}
