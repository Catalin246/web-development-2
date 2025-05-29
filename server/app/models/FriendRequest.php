<?php

namespace App\Models;

class FriendRequest extends Model
{
    public function create(int $senderId, int $receiverId)
    {
        // Prevent sending friend request to yourself
        if ($senderId === $receiverId) {
            throw new \InvalidArgumentException('Cannot send friend request to yourself');
        }

        // Check if request already exists
        $stmt = self::$pdo->prepare("
            SELECT * FROM friend_requests 
            WHERE (sender_id = ? AND receiver_id = ?) 
               OR (sender_id = ? AND receiver_id = ?)
        ");
        $stmt->execute([$senderId, $receiverId, $receiverId, $senderId]);
        if ($stmt->fetch()) {
            throw new \InvalidArgumentException('Friend request already exists or users are already friends');
        }

        // Insert new friend request with 'pending' status by default
        $stmt = self::$pdo->prepare("
            INSERT INTO friend_requests (sender_id, receiver_id, status) 
            VALUES (?, ?, 'pending')
        ");
        $stmt->execute([$senderId, $receiverId]);

        $requestId = self::$pdo->lastInsertId();
        return $this->findById((int)$requestId);
    }

    public function findById(int $id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM friend_requests WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    // Get all friend requests for a user, including user details for sender and receiver
    public function getRequestsForUser(int $userId)
    {
        $stmt = self::$pdo->prepare("
            SELECT fr.*, 
                sender.name AS sender_name, sender.email AS sender_email, sender.avatar AS sender_avatar,
                receiver.name AS receiver_name, receiver.email AS receiver_email, receiver.avatar AS receiver_avatar
            FROM friend_requests fr
            JOIN users sender ON fr.sender_id = sender.id
            JOIN users receiver ON fr.receiver_id = receiver.id
            WHERE fr.receiver_id = ? AND fr.status = 'pending'
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Update the status of a friend request (accepted/declined)
    public function updateStatus(int $id, string $status)
    {
        if (!in_array($status, ['pending', 'accepted', 'declined'])) {
            throw new \InvalidArgumentException('Invalid status');
        }

        $stmt = self::$pdo->prepare("UPDATE friend_requests SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }
}
