<?php
require_once __DIR__ . '/src/controllers/webhookController.php';

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    handleIncomingMessage($data);
}
