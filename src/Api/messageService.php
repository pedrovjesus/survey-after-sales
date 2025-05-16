<?php
require_once __DIR__ . '/../utils/DebugCurl.php'; // <-- IMPORTANTE

function sendMessage($phone, $message): array
{
    $config = require __DIR__ . '/../Config/Auth.php';

    $url = $config['base_url'] . '/instances/' . $config['instance_id'] . '/token/' . $config['token'] . '/send-text';

    $data = [
        'phone' => $phone,
        'message' => $message
    ];

    $headers = [
        'Content-Type: application/json',
        'Client-Token: ' . $config['client_token'],
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $responseRaw = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    curl_close($ch);

    debugCurl($url, $headers, $data, $responseRaw);

    if ($responseRaw === false) {
        return [
            'status' => $httpCode,
            'error' => 'CURL_ERROR',
            'message' => $error,
        ];
    }

    $decoded = json_decode($responseRaw, true);

    if ($decoded === null) {
        return [
            'status' => $httpCode,
            'error' => 'INVALID_RESPONSE',
            'message' => 'Resposta da API não é um JSON válido.',
            'raw' => $responseRaw,
        ];
    }

    return [
        'status' => $httpCode,
        'body' => $decoded
    ];
}
