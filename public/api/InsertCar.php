<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Only POST method is allowed.']);
    exit;
}

if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    echo json_encode(['error' => 'Invalid CSRF token.']);
    exit;
}

require_once "../../src/config/db.php";

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    http_response_code(401);
    echo json_encode(['error' => 'User not authenticated.']);
    exit;
}

// Validate required fields
$requiredFields = ['brand_id', 'model_id', 'year', 'mileage', 'transmission', 'fuel_type', 'price'];
foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Missing required field: $field"]);
        exit;
    }
}

$brand_id = $_POST['brand_id'];
$model_id = $_POST['model_id'];
$year = $_POST['year'];
$mileage = $_POST['mileage'];
$transmission = $_POST['transmission'];
$fuel_type = $_POST['fuel_type'];
$price = $_POST['price'];
$description = $_POST['description'] ?? '';

if (!isset($_FILES['carImage']) || $_FILES['carImage']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No image uploaded or upload error.']);
    exit;
}

$tmpName = $_FILES['carImage']['tmp_name'];
$originalName = $_FILES['carImage']['name'];
$fileInfo = pathinfo($originalName);
$extension = strtolower($fileInfo['extension'] ?? '');

$allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $tmpName);
finfo_close($finfo);

if (!in_array($extension, $allowedExts) || !in_array($mimeType, $allowedMimeTypes)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid file type.']);
    exit;
}

// Upload directory
$uploadDir = __DIR__ . '../../../src/uploads/';
if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to create upload directory.']);
    exit;
}

$newFileName = uniqid('car_', true) . '.' . $extension;
$destination = $uploadDir . $newFileName;

if (!move_uploaded_file($tmpName, $destination)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to move uploaded file.']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        INSERT INTO cars 
        (user_id, brand_id, model_id, year, mileage, transmission, fuel_type, price, description, image_filename, created_at, updated_at) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
    ");

    $stmt->execute([
        $user_id,
        $brand_id,
        $model_id,
        $year,
        $mileage,
        $transmission,
        $fuel_type,
        $price,
        $description,
        $newFileName
    ]);

    http_response_code(201);
    echo json_encode([
        'success' => true,
        'message' => 'Car added successfully!',
        'filename' => $newFileName
    ]);
} catch (PDOException $e) {
    if (file_exists($destination)) {
        unlink($destination);
    }
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

exit;
