<?php
require_once __DIR__ . '/../utils/questionHelper.php';
require_once __DIR__ . '/messageService.php';
require_once __DIR__ . '/../Config/configDB.php';

function sendNextQuestionToCustomer(string $phone): array
{
    $pdo = getConnection();

    $stmt = $pdo->prepare("SELECT id FROM customers WHERE phone = :phone");
    $stmt->execute(['phone' => $phone]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer) {
        $stmt = $pdo->prepare("INSERT INTO customers (phone) VALUES (:phone)");
        $stmt->execute(['phone' => $phone]);
        $customerId = $pdo->lastInsertId();
    } else {
        $customerId = $customer['id'];
    }

    // Pega a próxima pergunta não respondida
    $question = getNextQuestion($pdo, $customerId);

    if ($question) {
        return sendMessage($phone, $question['text']);
    } else {
        return sendMessage($phone, "Você já respondeu todas as perguntas. Obrigado!");
    }

}
