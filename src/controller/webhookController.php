<?php
require_once __DIR__ . '/../Config/configDB.php';
require_once __DIR__ . '/../utils/questionHelper.php';
require_once __DIR__ . '/../services/messageService.php';

function handleIncomingMessage(array $data)
{
    $pdo = getConnection();

    $phone = $data['from'] ?? null;
    $message = $data['message'] ?? null;

    if (!$phone || !$message)
        return;

    // Pega o cliente
    $stmt = $pdo->prepare("SELECT id FROM customers WHERE phone = :phone");
    $stmt->execute(['phone' => $phone]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$customer)
        return;

    $customerId = $customer['id'];

    // Verifica a próxima pergunta
    $question = getNextQuestion($pdo, $customerId);

    if ($question) {
        // Salva a resposta
        $stmt = $pdo->prepare("INSERT INTO responses (customer_id, question_id, answer) VALUES (:cid, :qid, :ans)");
        $stmt->execute([
            'cid' => $customerId,
            'qid' => $question['id'],
            'ans' => $message
        ]);

        // Pega a próxima pergunta após essa
        $nextQuestion = getNextQuestion($pdo, $customerId);

        if ($nextQuestion) {
            sendMessage($phone, $nextQuestion['text']);
        } else {
            sendMessage($phone, "Obrigado por concluir nossa pesquisa!");
        }
    } else {
        sendMessage($phone, "Você já concluiu a pesquisa. 😊");
    }
}
