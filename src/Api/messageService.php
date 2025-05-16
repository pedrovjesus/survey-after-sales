<?php
function sendMessage($phone, $message): array
{
    $config = require __DIR__ . '/../Config/Auth.php';

    $url = $config['base_url'] . '/instances/' . $config['instance_id'] . '/token/' . $config['token'] . '/send-message';

    $data = [
        'phone' => $phone,
        'message' => $message
    ];

    $clientToken = getenv('ZAPI_CLIENT_TOKEN');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'client-token: ' . $clientToken,
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $responseRaw = curl_exec($ch);

    if ($responseRaw === false) {
        // Trata erro do curl
        $error = curl_error($ch);
        curl_close($ch);
        // Retorna um array com erro para tratar fora
        return [
            'error' => 'CURL_ERROR',
            'message' => $error,
        ];
    }

    curl_close($ch);

    $decoded = json_decode($responseRaw, true);

    if ($decoded === null) {
        // JSON inválido ou vazio
        return [
            'error' => 'INVALID_RESPONSE',
            'message' => 'Resposta da API não é um JSON válido.',
            'raw' => $responseRaw,
        ];
    }

    return $decoded;
}

