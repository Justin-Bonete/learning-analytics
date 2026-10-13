<?php

$isLocal = in_array($_SERVER['SERVER_NAME'] ?? '', ['localhost', '127.0.0.1'])
        || PHP_SAPI === 'cli';

$envFile = dirname(__DIR__) . DIRECTORY_SEPARATOR . '.env';
if (is_file($envFile)) {
    $localSettings = parse_ini_file($envFile, false, INI_SCANNER_RAW);
    if ($localSettings === false) {
        error_log('Unable to parse the local .env file.');
        die('Database configuration error.');
    }

    foreach ($localSettings as $name => $value) {
        if (getenv($name) === false) {
            putenv($name . '=' . $value);
        }
    }
}

$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$database = getenv('DB_DATABASE');
$port = $port === false || $port === '' ? '3306' : $port;

if ($isLocal) {
    $host = $host === false ? '127.0.0.1' : $host;
    $username = $username === false ? 'root' : $username;
    $password = $password === false ? '' : $password;
    $database = $database === false ? 'navarro_mit' : $database;
} else {
    $missingSettings = [];
    foreach ([
        'DB_HOST' => $host,
        'DB_USERNAME' => $username,
        'DB_PASSWORD' => $password,
        'DB_DATABASE' => $database,
    ] as $name => $value) {
        if ($value === false || $value === '') {
            $missingSettings[] = $name;
        }
    }

    if ($missingSettings) {
        error_log('Missing database environment variables: ' . implode(', ', $missingSettings));
        die('Database configuration is incomplete.');
    }
}

$port = (int)($port === false || $port === '' ? 3306 : $port);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $username, $password, $database, $port);
    $conn->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    error_log($e->getMessage());
    die("Database connection failed.");
}

// Keep old variable names working for existing code
$DB = $conn;
$SERVER = $host; $USERNAME = $username; $PASSWORD = $password; $DB_NAME = $database;
