<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Only POST method is allowed."]);
    exit;
}

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo json_encode(["error" => "Invalid CSRF token."]);
    exit;
}

if (!isset($_POST["username"], $_POST["password"], $_POST["confirm_password"])) {
    http_response_code(400);
    echo json_encode(["error" => "Missing form data."]);
    exit;
}

require_once "../../src/config/db.php";

$username = trim($_POST["username"]);
$password = $_POST["password"];
$confirmPassword = $_POST["confirm_password"];

if ($username === "") {
    http_response_code(400);
    echo json_encode(["error" => "Please enter a username."]);
    exit;
}

if ($password !== $confirmPassword) {
    http_response_code(400);
    echo json_encode(["error" => "Passwords do not match."]);
    exit;
}

$passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/";

if (!preg_match($passwordPattern, $password)) {
    http_response_code(400);
    echo json_encode(["error" => "Password does not meet strength requirements."]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password)");
    $stmt->execute([
        ':username' => $username,
        ':password' => $hashedPassword
    ]);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(["error" => "Failed to retrieve user ID."]);
        exit;
    }

    $pdo->commit();

    $_SESSION['user_id'] = $user['id'];

    http_response_code(201);
    echo json_encode([
        "success" => true,
        "message" => "Account created successfully!",
        "redirect" => "../pages/dashboard.php"
    ]);
} catch (PDOException $e) {
    $pdo->rollBack();
    if ($e->getCode() == 23000) {
        http_response_code(409);
        echo json_encode(["error" => "Username already taken."]);
        exit;
    }
    http_response_code(500);
    echo json_encode(["error" => "Database error: " . $e->getMessage()]);
    exit;
}
