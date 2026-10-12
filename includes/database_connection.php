<?php

$isLocal = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1'])
        || PHP_SAPI === 'cli';

if ($isLocal) {
    $host     = "localhost";
    $username = "root";
    $password = "";
    $database = "navarro_mit";
} else {
    $host     = "localhost";
    $username = "u186176140_navarro";
    $password = "NavarroTester123!";
    $database = "u186176140_navarro";
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $username, $password, $database);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    die("Database connection failed.");
}

// Keep old variable names working for existing code
$DB = $conn;
$SERVER = $host; $USERNAME = $username; $PASSWORD = $password; $DB_NAME = $database;