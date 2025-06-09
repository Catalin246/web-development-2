<?php

/**
 * Setup
 */

// require autoload file to autoload vendor libraries
require_once __DIR__ . '/../vendor/autoload.php';

// require local classes
use App\Services\EnvService;
use App\Services\ErrorReportingService;
use App\Services\ResponseService;
use App\Controllers\AuthController;
use App\Controllers\FriendRequestController;
use App\Controllers\UserSettingController;
use App\Controllers\ChatController;

// require vendor libraries
use Steampixel\Route;

// initialize global environment variables
EnvService::Init();

// initialize error reporting (on in local env)
ErrorReportingService::Init();

// set CORS headers
ResponseService::SetCorsHeaders();

/**
 * Helper to protect routes with token authentication
 */
function authorizeAndRun(callable $callback) {
    $controller = new AuthController();
    try {
        $user = $controller->getAuthenticatedUser(); // throws if unauthorized
        $callback($user);
    } catch (\Exception $e) {
        ResponseService::Error('Unauthorized', 401);
    }
}

/**
 * Main application routes
 */
// top level fail-safe try/catch
try {
    /**
     * Auth routes
     */
    Route::add('/auth/register', function () {
        $authController = new AuthController();
        $authController->register();
    }, ["post"]);

    Route::add('/auth/login', function () {
        $authController = new AuthController();
        $authController->login();
    }, ["post"]);

    Route::add('/auth/me', function () {
        $authController = new AuthController();
        $authController->me();
    }, ["get"]);

    Route::add('/auth/is-me/([0-9]*)', function ($id) {
        $authController = new AuthController();
        $authController->isMe($id);
    }, 'get');

    Route::add('/auth/update-profile', function () {
        $authController = new AuthController();
        $authController->updateStatusAbout();
    }, ['put']);

    /**
     * Friend Requests routes (protected)
     */

    // Send a friend request
    Route::add('/friend-requests', function () {
        authorizeAndRun(function ($user) {
            $friendRequestController = new FriendRequestController();
            $friendRequestController->sendRequest();
        });
    }, ['post']);

    // List received friend requests
    Route::add('/friend-requests', function () {
        authorizeAndRun(function ($user) {
            $friendRequestController = new FriendRequestController();
            $friendRequestController->listRequests();
        });
    }, ['get']);

    // Respond to a friend request (accept/decline)
    Route::add('/friend-requests/([0-9]+)', function ($id) {
        authorizeAndRun(function ($user) use ($id) {
            $friendRequestController = new FriendRequestController();
            $friendRequestController->respondRequest($id);
        });
    }, ['put']);

    // Discover users the logged-in user is not already connected with (no accepted or pending friend request)
    Route::add('/friends/discover', function () {
        $controller = new FriendRequestController();
        $controller->discoverFriends();
    }, ['get']);

    Route::add('/friends/list', function () {
        $controller = new FriendRequestController();
        $controller->getFriends();
    }, ['get']);

     /**
     * User Settings routes (protected)
     */
    Route::add('/settings', function () {
        authorizeAndRun(function ($user) {
            $controller = new UserSettingController();
            $controller->get();
        });
    }, ['get']);

    Route::add('/settings', function () {
        authorizeAndRun(function ($user) {
            $controller = new UserSettingController();
            $controller->update();
        });
    }, ['put']);
    
    /**
     * Chat routes (protected)
     */

    // Create a new chat
    Route::add('/chats', function () {
        authorizeAndRun(function ($user) {
            $controller = new ChatController();
            $controller->createChat();
        });
    }, ['post']);

    // Send a message in a chat
    Route::add('/chats/([0-9]+)/messages', function ($chatId) {
        authorizeAndRun(function ($user) use ($chatId) {
            $controller = new ChatController();
            $controller->sendMessage($chatId);
        });
    }, ['post']);

    // Get messages in a chat
    Route::add('/chats/([0-9]+)/messages', function ($chatId) {
        authorizeAndRun(function ($user) use ($chatId) {
            $controller = new ChatController();
            $controller->getMessages($chatId);
        });
    }, ['get']);

    // Get participants of a chat
    Route::add('/chats/([0-9]+)/participants', function ($chatId) {
        authorizeAndRun(function ($user) use ($chatId) {
            $controller = new ChatController();
            $controller->getParticipants($chatId);
        });
    }, ['get']);

    // Get a single chat's info
    Route::add('/chats/([0-9]+)', function ($chatId) {
        authorizeAndRun(function ($user) use ($chatId) {
            $controller = new ChatController();
            $controller->getChat($chatId);
        });
    }, ['get']);

    // Get chats for a user
    Route::add('/chats', function () {
        authorizeAndRun(function ($user) {
            $controller = new ChatController();
            $controller->getChatsForUser();
        });
    }, ['get']);

    /**
     * 404 route handler
     */
    Route::pathNotFound(function () {
        ResponseService::Error("route is not defined", 404);
    });
} catch (\Throwable $error) {
    if ($_ENV["environment"] == "LOCAL") {
        var_dump($error);
    } else {
        error_log($error);
    }
    ResponseService::Error("A server error occurred");
}

Route::run();
