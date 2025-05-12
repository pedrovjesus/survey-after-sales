<?php
// webhook.php
$input = json_decode(file_get_contents('php://input'), true);

$phone = $input['from'] ?? null;
$message = $input['message'] ?? null;

