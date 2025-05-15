<?php
require_once __DIR__ . '/../src/Api/questionService.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $phone = $data['phone'] ?? null;
    $cleanPhone = preg_replace('/\D/', '', $phone);

    if ($cleanPhone) {
        $result = sendNextQuestionToCustomer($cleanPhone);

        http_response_code($result['status'] ?? 500);
        echo json_encode([
            'message' => 'Mensagem enviada.',
            'status' => $result['status'] ?? 'indefinido',
            'response' => $result['body'] ?? 'sem resposta'
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Número inválido.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
