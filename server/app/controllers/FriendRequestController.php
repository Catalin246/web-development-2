<?php

namespace App\Controllers;

use App\Models\FriendRequest;
use App\Services\ResponseService;

class FriendRequestController extends Controller
{
    private $friendRequestModel;

    public function __construct()
    {
        $this->friendRequestModel = new FriendRequest();
    }

    // Send a friend request
    public function sendRequest()
    {
        $data = $this->decodePostData();
        $this->validateInput(['receiver_id'], $data);

        $sender = $this->getAuthenticatedUser();
        $receiverId = (int)$data['receiver_id'];

        try {
            $request = $this->friendRequestModel->create($sender->id, $receiverId);
            ResponseService::Send(['message' => 'Friend request sent', 'request' => $request]);
        } catch (\Exception $e) {
            ResponseService::Error($e->getMessage(), 400);
        }
    }

    // List friend requests received by authenticated user with sender info
    public function listRequests()
    {
        $user = $this->getAuthenticatedUser();
        $requests = $this->friendRequestModel->getRequestsForUser($user->id);

        ResponseService::Send(['requests' => $requests]);
    }

    // Accept or decline a friend request
    public function respondRequest($requestId)
    {
        $data = $this->decodePostData();
        $this->validateInput(['status'], $data);

        $status = strtolower($data['status']);
        if (!in_array($status, ['accepted', 'declined'])) {
            ResponseService::Error('Invalid status value', 400);
            return;
        }

        $user = $this->getAuthenticatedUser();

        // Fetch the request first to verify ownership
        $request = $this->friendRequestModel->findById((int)$requestId);
        if (!$request) {
            ResponseService::Error('Friend request not found', 404);
            return;
        }

        // Only the receiver can accept/decline
        if ($request['receiver_id'] != $user->id) {
            ResponseService::Error('Unauthorized action', 403);
            return;
        }

        $updated = $this->friendRequestModel->updateStatus((int)$requestId, $status);

        if ($updated) {
            ResponseService::Send(['message' => "Friend request {$status} successfully"]);
        } else {
            ResponseService::Error('Failed to update friend request status', 500);
        }
    }

    public function discoverFriends()
    {
        $user = $this->getAuthenticatedUser();
        $users = $this->friendRequestModel->discoverFriends($user->id);
        ResponseService::Send($users);
    }

    public function getFriends()
    {
        $authUser = $this->getAuthenticatedUser();
        $friends = $this->friendRequestModel->getFriends($authUser->id);
        ResponseService::Send($friends);
    }
}
