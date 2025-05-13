<?php
require_once __DIR__ . '/../src/Api/questionService.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lê o corpo da requisição JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Verifica se o campo 'phone' existe no JSON
    $phone = $data['phone'] ?? null;

    // Limpeza do número (removendo caracteres não numéricos)
    $cleanPhone = preg_replace('/\D/', '', $phone);

    // Verifica se o número foi encontrado e está correto
    if ($cleanPhone) {
        sendNextQuestionToCustomer($cleanPhone);
        echo "Pesquisa iniciada para o número $cleanPhone";
    } else {
        http_response_code(400);
        echo "Número inválido.";
    }
} else {
    http_response_code(405);
    echo "Método não permitido.";
}
