<?php
session_start();
header('Content-Type: application/json');

// Validate CSRF token from header
$headers = getallheaders();
$csrf_token = $headers['X-CSRF-Token'] ?? '';

if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    http_response_code(403);
    echo json_encode([
        "success" => false,
        "message" => "Invalid CSRF token."
    ]);
    exit;
}

// If no user logged in, just return success anyway
if (!isset($_SESSION['user_id'])) {
    http_response_code(200);
    echo json_encode([
        "success" => true,
        "message" => "Already logged out."
    ]);
    exit;
}

// Clear all session data
$_SESSION = [];

// Destroy session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
    );
}

// Destroy the session
session_destroy();

http_response_code(200);
echo json_encode([
    "success" => true,
    "message" => "Logged out successfully."
]);
