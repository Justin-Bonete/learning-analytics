<?php

if (session_status() === PHP_SESSION_NONE) {
}

$host = $_SERVER['HTTP_HOST'] ?? '';
$isLocal = in_array(
    strtolower(explode(':', $host)[0]),
    ['localhost', '127.0.0.1', '::1']
);

error_reporting(E_ALL);

ini_set('log_errors', '1');

if ($isLocal) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
}

set_error_handler(function ($severity, $message, $file, $line) {
    if (!(error_reporting() & $severity)) {
        return false;
    }

    error_log(
        "[PHP DEBUG] {$message} in {$file}:{$line}"
    );

    if ($GLOBALS['isLocal'] ?? false) {
        echo '<div style="background:#fff3cd;color:#664d03;'
           . 'padding:12px;margin:8px;border:1px solid #ffda6a;'
           . 'font:14px monospace;overflow-wrap:anywhere">'
           . '<b>PHP ERROR</b><br>'
           . htmlspecialchars($message, ENT_QUOTES, 'UTF-8')
           . '<br>File: '
           . htmlspecialchars($file, ENT_QUOTES, 'UTF-8')
           . '<br>Line: ' . (int)$line
           . '</div>';
    }

    return true;
});

set_exception_handler(function (Throwable $e) {
    error_log(
        '[UNCAUGHT EXCEPTION] ' . $e->getMessage()
        . ' in ' . $e->getFile() . ':' . $e->getLine()
    );

    if ($GLOBALS['isLocal'] ?? false) {
        echo '<div style="background:#fee2e2;color:#991b1b;'
           . 'padding:15px;margin:10px;border:1px solid #ef4444;'
           . 'font:14px monospace;overflow-wrap:anywhere">';
        echo '<h3>UNCAUGHT EXCEPTION</h3>';
        echo '<b>Message:</b> ' .
            htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
        echo '<br><b>File:</b> ' .
            htmlspecialchars($e->getFile(), ENT_QUOTES, 'UTF-8');
        echo '<br><b>Line:</b> ' . (int)$e->getLine();
        echo '<pre style="white-space:pre-wrap">' .
            htmlspecialchars($e->getTraceAsString(), ENT_QUOTES, 'UTF-8') .
            '</pre></div>';
    } else {
        http_response_code(500);
        echo 'An unexpected error occurred.';
    }
});

register_shutdown_function(function () {
    $error = error_get_last();

    if ($error && in_array($error['type'], [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR
    ], true)) {
        error_log(
            "[FATAL PHP ERROR] {$error['message']} in "
            . "{$error['file']}:{$error['line']}"
        );
    }
});
?>
