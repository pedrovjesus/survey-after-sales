<?php
require_once __DIR__ . '/../src/controllers/webhookController.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    handleIncomingMessage($data);
    http_response_code(200);
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'No data received']);
}
