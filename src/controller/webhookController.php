<?php
require_once __DIR__ . '/../../db/database.php';
require_once __DIR__ . '/../utils/questionHelper.php';
require_once __DIR__ . '/../services/messageService.php';

function handleWebhook(array $data)
{
    $pdo = getConnection();
    $phone = $data['from'] ?? null;
    $message = $data['message'] ?? null;

    if (!$phone || !$message)
        return;

    // Buscar cliente
    $stmt = $pdo->prepare("SELECT id FROM customers WHERE phone = :phone");
    $stmt->execute(['phone' => $phone]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer)
        return;

    $customerId = $customer['id'];

    // Descobre qual pergunta estamos respondendo
    $questionId = getNextQuestionId($pdo, $customerId);

    if ($questionId !== null) {
        // Grava resposta
        $stmt = $pdo->prepare("INSERT INTO responses (customer_id, question_id, answer) VALUES (:cid, :qid, :ans)");
        $stmt->execute([
            'cid' => $customerId,
            'qid' => $questionId,
            'ans' => $message
        ]);

        // Pega próxima pergunta
        $nextQuestionId = getNextQuestionId($pdo, $customerId);

        if ($nextQuestionId !== null) {
            $stmt = $pdo->prepare("SELECT text FROM questions WHERE id = :id");
            $stmt->execute(['id' => $nextQuestionId]);
            $question = $stmt->fetch(PDO::FETCH_ASSOC)['text'];
            sendMessage($phone, $question);
        } else {
            sendMessage($phone, "Obrigado por responder nossa pesquisa!");
        }
    }
}
