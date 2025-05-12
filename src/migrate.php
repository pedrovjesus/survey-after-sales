<?php
require_once __DIR__ . '/db/database.php';
$pdo = getConnection();

// Lista os arquivos da pasta migrations
$migrations = glob(__DIR__ . '/migrations/*.php');

// Ordena para garantir que rodem na ordem certa
sort($migrations);

// Roda cada migration
foreach ($migrations as $migrationFile) {
    require_once $migrationFile;

    // Extrai o nome da função baseado no nome do arquivo
    $functionName = 'migrate_' . basename($migrationFile, '.php');
    if (function_exists($functionName)) {
        $functionName($pdo);
        echo "Migration $functionName executada.\n";
    }
}
