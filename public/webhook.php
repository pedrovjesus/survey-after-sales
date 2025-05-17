<?php
require_once __DIR__ . '/../src/Config/configDB.php';
require_once __DIR__ . '/../src/utils/questionHelper.php';
require_once __DIR__ . '/../src/Api/messageService.php';
require_once __DIR__ . '/../src/controller/webhookController.php';


header('Content-Type: application/json');

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

if (!$data) {
    echo json_encode(['error' => 'JSON inválido ou vazio']);
    exit;
}

handleIncomingMessage($data);

echo json_encode(['status' => 'ok']);
