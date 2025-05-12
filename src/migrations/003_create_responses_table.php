<?php
function migrate_003_create_responses_table(PDO $pdo)
{
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS responses (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_id INT NOT NULL,
            question_id INT NOT NULL,
            answer TEXT,
            answered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (customer_id) REFERENCES customers(id),
            FOREIGN KEY (question_id) REFERENCES questions(id)
        )
    ");
}
