<?php

namespace App\Controllers;

use App\Models\Chat;
use App\Services\ResponseService;

class ChatController extends Controller
{
    private $chatModel;

    public function __construct()
    {
        $this->chatModel = new Chat();
    }

    public function createChat()
    {
        $authenticatedUser = $this->getAuthenticatedUser();
        $data = $this->decodePostData();

        $this->validateInput(['name', 'participant_ids'], $data);

        // Ensure the current user is part of the chat
        if (!in_array($authenticatedUser->id, $data['participant_ids'])) {
            $data['participant_ids'][] = $authenticatedUser->id;
        }

        $type = count($data['participant_ids']) > 2 ? 'group' : 'normal';

        try {
            $chat = $this->chatModel->create(
                 $type,
                $data['name'],
                $data['avatar'] ?? null,
                $data['participant_ids']
            );

            ResponseService::Send(['chat' => $chat]);
        } catch (\Exception $e) {
            ResponseService::Error('Chat creation failed: ' . $e->getMessage(), 500);
        }
    }

    public function sendMessage($chatId)
    {
        $authenticatedUser = $this->getAuthenticatedUser();
        $data = $this->decodePostData();

        $this->validateInput(['text'], $data);

        try {
            $message = $this->chatModel->addMessage(
                $chatId,
                $authenticatedUser->id,
                $data['text']
            );

            ResponseService::Send(['message' => $message]);
        } catch (\Exception $e) {
            ResponseService::Error('Failed to send message: ' . $e->getMessage(), 500);
        }
    }

    public function getMessages($chatId)
    {
        try {
            $messages = $this->chatModel->getMessages($chatId);
            ResponseService::Send(['messages' => $messages]);
        } catch (\Exception $e) {
            ResponseService::Error('Failed to fetch messages: ' . $e->getMessage(), 500);
        }
    }

    public function getParticipants($chatId)
    {
        try {
            $participants = $this->chatModel->getParticipants($chatId);
            ResponseService::Send(['participants' => $participants]);
        } catch (\Exception $e) {
            ResponseService::Error('Failed to fetch participants: ' . $e->getMessage(), 500);
        }
    }

    public function getChat($chatId)
    {
        try {
            $chat = $this->chatModel->findById($chatId);

            if (!$chat) {
                ResponseService::Error('Chat not found', 404);
                return;
            }

            ResponseService::Send(['chat' => $chat]);
        } catch (\Exception $e) {
            ResponseService::Error('Failed to fetch chat: ' . $e->getMessage(), 500);
        }
    }
}
