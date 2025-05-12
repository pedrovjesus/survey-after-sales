<?php
const DBDRIVER = 'mysql';
const DBHOST = 'localhost';
const DBNAME = 'survey';
const DBUSER = 'root';
const DBPASS = '';

function getConnection(): PDO
{
    $dsn = DBDRIVER . ":host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
