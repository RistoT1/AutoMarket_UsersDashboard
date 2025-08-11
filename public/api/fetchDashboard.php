<?php
session_start();
header('Content-Type: application/json');
require_once "../../src/config/db.php";

// Check if logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Not authenticated."
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE user_id = ? ORDER BY id");
    $stmt->execute([$user_id]);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "cars" => $cars
    ]);

} catch (PDOException $e) {
    echo json_encode([
        "success" => false,
        "message" => "Database query failed: " . $e->getMessage()
    ]);
}
?>