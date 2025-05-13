<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

return [
    'instance_id' => $_ENV['ZAPI_INSTANCE_ID'],
    'token' => $_ENV['ZAPI_TOKEN'],
    'base_url' => $_ENV['ZAPI_BASE_URL'],
    'client_token' => $_ENV['ZAPI_CLIENT_TOKEN']
];