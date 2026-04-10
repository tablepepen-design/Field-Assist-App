<?php
$host = '127.0.0.1';
$db = 'field_assist';
$user = 'root';
$pass = ''; // Default XAMPP password is empty
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

// Google Sheet Sync Configuration
define('GOOGLE_SCRIPT_URL', 'https://script.google.com/macros/s/AKfycbw-AryF1rXN1mjkupUA26cHpGveZDEse4VADSQGgqejIsjMoKl3p6UqbC4-SqDcH3c/exec');
define('SYNC_API_KEY', 'MORARKA_SYNC_2026');
?>