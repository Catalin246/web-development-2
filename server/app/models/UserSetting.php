<?php

namespace App\Models;

class UserSetting extends Model
{
    public function getByUserId($userId)
    {
        $stmt = self::$pdo->prepare("SELECT notifications, dark_mode, privacy_mode FROM user_settings WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function updateByUserId($userId, $fields)
    {
        $columns = [];
        $params = [];

        foreach ($fields as $key => $value) {
            $columns[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $userId;

        $sql = "UPDATE user_settings SET " . implode(', ', $columns) . " WHERE user_id = ?";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($params);
    }
}
