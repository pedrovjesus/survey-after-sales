<?php
function migrate_002_create_questions_table(PDO $pdo) {
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS questions (
            id INT AUTO_INCREMENT PRIMARY KEY,
            text TEXT NOT NULL
        )
    ");
}
