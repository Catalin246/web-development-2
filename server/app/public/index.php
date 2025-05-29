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
