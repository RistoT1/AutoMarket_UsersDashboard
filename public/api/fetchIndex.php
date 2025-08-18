<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../../src/config/db.php";  // safer with __DIR__

$response = [
    "success" => false,
    "error" => [
        "type" => "unknown",
        "message" => "An unexpected error occurred."
    ],
    "car_post" => []
];

$action = $_GET['action'] ?? '';

try {
    if ($action === "foryou") {
        $stmt = $pdo->prepare("SELECT * FROM cars ORDER BY id");
        $stmt->execute();
        $car_posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($car_posts) {
            foreach ($car_posts as &$car) {
                if (!empty($car['image_filename'])) {
                    $car['image_url'] = "/api/image.php?file=" . urlencode($car['image_filename']);
                } else {
                    $car['image_url'] = null;
                }
            }

            $response["success"] = true;
            $response["car_post"] = $car_posts;
            unset($response["error"]);
        } else {
            $response["error"] = [
                "type" => "not_found",
                "message" => "No cars found."
            ];
        }
    } else {
        $response["error"] = [
            "type" => "invalid_parameters",
            "message" => "Invalid or missing parameters."
        ];
    }
} catch (PDOException $e) {
    $response["error"] = [
        "type" => "database",
        "message" => "Database query failed.",
        "details" => $e->getMessage()
    ];
}

echo json_encode($response);
