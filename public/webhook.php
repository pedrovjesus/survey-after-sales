<?php
// webhook.php
$input = json_decode(file_get_contents('php://input'), true);
$conn = require_once __DIR__ . '/../src/config/configDB.php';
$conn = getConnection();
$phone = $input['from'] ?? null;
$message = $input['message'] ?? null;

$stmt = $conn->prepare("SELECT id FROM customers WHERE phone = :phone");
$stmt->execute(['phone' => $phone]);
$customer = $stmt->fetch(PDO::FETCH_ASSOC);

if ($customer) {
    $customerId = $customer['id'];
    $questionId = getNextQuestionId($conn, $customerId);
} else {
    $stmt = $conn->prepare("INSERT INTO responses (customer_id, question_id, answer) VALUES (:cid, :qid, :ans)");
    $stmt->execute([
        'cid' => $customerId,
        'qid' => $questionId,
        'ans' => $message
    ]);

    $nextQuestionId = getNextQuestionId($conn, $customerId);
    if ($nextQuestionId) {
        $stmt = $conn->prepare("SELECT question FROM questions WHERE id = :qid");
        $stmt->execute(['qid' => $nextQuestionId]);
        $question = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['question' => $question['question']]);
    } else {
        echo json_encode(['message' => 'Obrigado por participar!']);
    }
}

