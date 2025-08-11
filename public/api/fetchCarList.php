<?php
// perus JSON + SQL fetch :>
header('Content-Type: application/json');
require_once "../../src/config/db.php";

$action = $_GET['action'] ?? '';

if ($action === "brands") {
    try {
        $stmt = $pdo->prepare("SELECT id, name FROM brands ORDER BY name");
        $stmt->execute();
        $brands = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($brands) {
            echo json_encode([
                "success" => true,
                "brands" => $brands
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Unable to fetch brands :("
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed (Brands): " . $e->getMessage()
        ]);
    }
} elseif ($action === "models" && isset($_GET['brand_id'])) {
    $brand_id = intval($_GET['brand_id']);
    try {
        $stmt = $pdo->prepare("SELECT id, name FROM models WHERE brand_id = ? ORDER BY id");
        $stmt->execute([$brand_id]);
        $models = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($models) {
            echo json_encode([
                "success" => true,
                "models" => $models
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "No models for this brand"
            ]);
        }
    } catch (PDOException $e) {
        echo json_encode([
            "success" => false,
            "message" => "Database query failed (Models): " . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid! or missing parameters"
    ]);
}
?>
