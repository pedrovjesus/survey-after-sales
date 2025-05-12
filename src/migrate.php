<?php
require_once __DIR__ . '/Config/configDB.php'; // <- ajustado

// Lista os arquivos de migration
$migrations = glob(__DIR__ . '/migrations/*.php');
sort($migrations);

$pdo = getConnection();

foreach ($migrations as $migrationFile) {
    require_once $migrationFile;

    $functionName = 'migrate_' . basename($migrationFile, '.php');

    if (function_exists($functionName)) {
        $functionName($pdo);
        echo "Migration $functionName executada com sucesso.\n";
    } else {
        echo "Função $functionName não encontrada.\n";
    }
}
