<?php
function sendMessage($phone, $message)
{
    $config = require __DIR__ . '/../../config/config.php';

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
    curl_close($ch);

    return json_decode($response, true);
}
