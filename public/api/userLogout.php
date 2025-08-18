<?php
// Prevent any output before JSON
ob_start();

// Disable HTML error reporting
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

// Start session
session_start();

// Clear any previous output
ob_clean();

// Set JSON header
header('Content-Type: application/json');

// Function to send JSON response and exit
function sendJsonResponse($data, $httpCode = 200) {
    http_response_code($httpCode);
    echo json_encode($data);
    exit;
}

// Default response
$response = [
    "success" => false,
    "message" => "Unknown error occurred.",
];

try {
    // Verify this is a POST request
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        sendJsonResponse([
            "success" => false,
            "message" => "Method not allowed."
        ], 405);
    }

    // Check if user is logged in first
    if (!isset($_SESSION['user_id'])) {
        sendJsonResponse([
            "success" => true,
            "message" => "User already logged out."
        ]);
    }

    // Get headers - check if function exists
    if (function_exists('getallheaders')) {
        $headers = getallheaders();
    } else {
        // Fallback for servers that don't have getallheaders()
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $header = str_replace('_', '-', substr($key, 5));
                $headers[$header] = $value;
            }
        }
    }

    // Check CSRF token
    $csrf_token = $headers['X-CSRF-Token'] ?? $headers['X-Csrf-Token'] ?? '';

    if (!$csrf_token) {
        sendJsonResponse([
            "success" => false,
            "message" => "CSRF token missing."
        ], 400);
    }

    if (!isset($_SESSION['csrf_token']) || $csrf_token !== $_SESSION['csrf_token']) {
        sendJsonResponse([
            "success" => false,
            "message" => "Invalid CSRF token."
        ], 403);
    }

    // Perform logout
    // Clear session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(), 
            '', 
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    // Clear session data
    $_SESSION = [];

    // Destroy session
    session_destroy();

    // Send success response
    sendJsonResponse([
        "success" => true,
        "message" => "Logged out successfully."
    ]);

} catch (Exception $e) {
    // Log error for debugging (don't expose to client)
    error_log("Logout error: " . $e->getMessage());
    
    sendJsonResponse([
        "success" => false,
        "message" => "Server error occurred during logout."
    ], 500);
} catch (Error $e) {
    // Catch fatal errors
    error_log("Logout fatal error: " . $e->getMessage());
    
    sendJsonResponse([
        "success" => false,
        "message" => "Server error occurred during logout."
    ], 500);
}

// This should never be reached, but just in case
sendJsonResponse([
    "success" => false,
    "message" => "Unexpected error occurred."
], 500);
?>