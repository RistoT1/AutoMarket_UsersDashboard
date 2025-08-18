<?php
// Simple test to verify the logout API returns JSON
header('Content-Type: application/json');

echo json_encode([
    "success" => true,
    "message" => "API endpoint is working",
    "timestamp" => date('Y-m-d H:i:s')
]);
?>
