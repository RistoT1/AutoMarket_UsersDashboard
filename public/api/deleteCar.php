<?php
session_start();
header('Content-Type: application/json');

require_once "../../src/config/db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$csrf_token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
if (!$csrf_token || $csrf_token !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$car_id = $input['car_id'] ?? null;

if (!$car_id || !is_numeric($car_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid car ID']);
    exit;
}

try {

    $stmt = $pdo->prepare("DELETE FROM cars WHERE id = ?");
    $stmt->execute([$car_id]);

    if ($stmt->rowCount() > 0) //kertoo kuinka moneen riviin SQL-lause vaikutti 
    {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Car not found or could not be deleted']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
