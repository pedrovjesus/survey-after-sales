<?php
function migrate_004_seed_questions(PDO $pdo)
{
    // Perguntas padrão para a pesquisa
    $questions = [
        'Como você avaliaria nosso atendimento?',
        'O que mais lhe agradou no nosso serviço?',
        'Como podemos melhorar nossa oferta de produtos?',
        'Você recomendaria nosso serviço a outras pessoas?',
        'Como você avaliaria sua experiência geral?'
    ];

    // Prepara a inserção
    $stmt = $pdo->prepare("INSERT INTO questions (text) VALUES (:text)");

    foreach ($questions as $question) {
        $stmt->execute(['text' => $question]);
    }

    echo "Perguntas adicionadas com sucesso.\n";
}
