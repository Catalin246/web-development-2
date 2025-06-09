<?php

namespace App\Models;

class Chat extends Model
{
    public function create($type, $name, $avatar, array $participantIds)
    {
        if (!in_array($type, ['group', 'normal'])) {
            throw new \InvalidArgumentException('Invalid chat type.');
        }

        if (empty($name) || strlen($name) > 255) {
            throw new \InvalidArgumentException('Invalid chat name.');
        }

        $stmt = self::$pdo->prepare("INSERT INTO chats (type, name, avatar) VALUES (?, ?, ?)");
        $stmt->execute([$type, $name, $avatar]);
        $chatId = self::$pdo->lastInsertId();

        // Insert participants
        $stmtPart = self::$pdo->prepare("INSERT INTO chat_participants (chat_id, user_id) VALUES (?, ?)");
        foreach ($participantIds as $userId) {
            $stmtPart->execute([$chatId, $userId]);
        }

        return $this->findById($chatId);
    }

    public function addMessage($chatId, $senderId, $text, $timestamp = null)
    {
        if (empty($text)) {
            throw new \InvalidArgumentException("Message text cannot be empty.");
        }

        $timestamp = $timestamp ?? date('Y-m-d H:i:s');

        $stmt = self::$pdo->prepare("INSERT INTO messages (chat_id, sender_id, text, timestamp, `read`) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$chatId, $senderId, $text, $timestamp, 0]);

        return $this->getMessageById(self::$pdo->lastInsertId());
    }

    public function getMessages($chatId)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM messages WHERE chat_id = ? ORDER BY timestamp ASC");
        $stmt->execute([$chatId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getParticipants($chatId)
    {
        $stmt = self::$pdo->prepare("
            SELECT u.id, u.name, u.avatar
            FROM chat_participants cp
            JOIN users u ON cp.user_id = u.id
            WHERE cp.chat_id = ?
        ");
        $stmt->execute([$chatId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM chats WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getMessageById($id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM messages WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getChatsForUser(int $userId)
    {
        $stmt = self::$pdo->prepare("
            SELECT c.*
            FROM chats c
            JOIN chat_participants cp ON c.id = cp.chat_id
            WHERE cp.user_id = ?
            ORDER BY c.id DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function markMessagesAsRead($chatId, $userId)
    {
        $stmt = self::$pdo->prepare("
            UPDATE messages
            SET `read` = 1
            WHERE chat_id = :chatId AND sender_id != :userId AND `read` = 0
        ");
        $stmt->execute([
            'chatId' => $chatId,
            'userId' => $userId
        ]);
    }

}
