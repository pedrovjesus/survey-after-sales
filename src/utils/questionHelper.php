<?php
function getNextQuestionId(PDO $pdo, int $customerId): ?int
{
    $stmt = $pdo->prepare("
        SELECT id FROM questions
        WHERE id NOT IN (
            SELECT question_id FROM responses WHERE customer_id = :cid
        )
        ORDER BY id ASC LIMIT 1
    ");
    $stmt->execute(['cid' => $customerId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result ? (int) $result['id'] : null;
}
