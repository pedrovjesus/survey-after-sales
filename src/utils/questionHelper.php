<?php
function getNextQuestionId(PDO $pdo, $customerId)
{
    $stmt = $pdo->prepare("SELECT question_id FROM responses WHERE customer_id = :customer_id ORDER BY id DESC LIMIT 1");
    $stmt->execute(['customer_id' => $customerId]);
    $lastAnswered = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($lastAnswered) {
        // Retorna o próximo id de pergunta
        return $lastAnswered['question_id'] + 1;
    } else {
        return 1;
    }
}

function getNextQuestion(PDO $pdo, int $customerId): ?array
{
    $stmt = $pdo->prepare("
        SELECT q.id, q.text
        FROM questions q
        WHERE q.id NOT IN (
            SELECT question_id FROM responses WHERE customer_id = :cid
        )
        ORDER BY q.id ASC
        LIMIT 1
    ");
    $stmt->execute(['cid' => $customerId]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}
