<?php
require_once __DIR__ . '/../src/Api/questionService.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['name']) || empty($data['phone'])) {
        http_response_code(400);
        echo json_encode([
            'error' => 'Campos obrigatórios ausentes.',
            'required_fields' => ['name', 'phone']
        ]);
        exit;
    }

    $phone = $data['phone'] ?? null;
    $cleanPhone = preg_replace('/\D/', '', $phone);

    if ($cleanPhone) {
        $result = sendNextQuestionToCustomer($cleanPhone);

        if (isset($result['error'])) {
            http_response_code(400);
            echo json_encode([
                'message' => 'Erro ao enviar mensagem.',
                'error' => $result['error'],
                'details' => $result['message'] ?? null,
            ]);
        } else {
            // Sucesso no envio
            http_response_code(200);
            echo json_encode([
                'message' => 'Mensagem enviada.',
                'response' => $result,
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Número inválido.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido.']);
}
