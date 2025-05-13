<?php
require_once __DIR__ . '/../utils/questionHelper.php';
require_once __DIR__ . '/../services/messageService.php';
require_once __DIR__ . '/../Config/configDB.php';

function sendNextQuestionToCustomer(string $phone)
{
    $pdo = getConnection();

    // Verifica se o cliente já existe
    $stmt = $pdo->prepare("SELECT id FROM customers WHERE phone = :phone");
    $stmt->execute(['phone' => $phone]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        // Cria novo cliente
        $stmt = $pdo->prepare("INSERT INTO customers (phone) VALUES (:phone)");
        $stmt->execute(['phone' => $phone]);
        $customerId = $pdo->lastInsertId();
    } else {
        $customerId = $customer['id'];
    }

    // Pega a próxima pergunta não respondida
    $question = getNextQuestion($pdo, $customerId);

    if ($question) {
        sendMessage($phone, $question['text']);
    } else {
        sendMessage($phone, "Você já respondeu todas as perguntas. Obrigado!");
    }
}
