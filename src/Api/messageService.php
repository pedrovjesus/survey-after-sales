<?php
function sendMessage($phone, $message): array
{
    $config = require __DIR__ . '/../Config/Auth.php';

    $url = $config['base_url'] . '/instances/' . $config['instance_id'] . '/token/' . $config['token'] . '/send-message';

    $data = [
        'phone' => $phone,
        'message' => $message
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if (isset($response['error'])) {
        $httpCode = 400; 
    }

    return [
        'body' => json_decode($response, true),
        'status' => $httpCode
    ];
}
