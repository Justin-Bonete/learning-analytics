
<?php
require_once __DIR__ . '/config.php';

$host = strtolower(explode(':', $_SERVER['HTTP_HOST'] ?? '')[0]);

if (!in_array($host, ['localhost', '127.0.0.1', '::1'], true)) {
    http_response_code(403);
    exit('Forbidden: diagnostics are available only on localhost.');
}

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

$checks = [];
$tables = [];

function checkResult(string $name, bool $ok, string $message): void
{
    global $checks;
    $checks[] = [
        'name' => $name,
        'ok' => $ok,
        'message' => $message
    ];
}

function h($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

try {
    if (isset($pdo) && $pdo instanceof PDO) {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $dbName = $pdo->query('SELECT DATABASE()')->fetchColumn();

        if (!$dbName) {
            throw new RuntimeException('No database is selected.');
        }

        checkResult('Database connection', true, 'Connected successfully');
        checkResult('Selected database', true, $dbName);

        $stmt = $pdo->query('SHOW TABLES');
        $tableNames = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tableNames as $table) {
            $quoted = '`' . str_replace('`', '``', $table) . '`';

            $columns = $pdo->query(
                "SHOW COLUMNS FROM {$quoted}"
            )->fetchAll(PDO::FETCH_ASSOC);

            $indexes = $pdo->query(
                "SHOW INDEX FROM {$quoted}"
            )->fetchAll(PDO::FETCH_ASSOC);

            $tables[] = [
                'name' => $table,
                'columns' => $columns,
                'indexes' => $indexes
            ];
        }

        checkResult(
            'Table inspection',
            true,
            count($tables) . ' table(s) found'
        );

    } elseif (isset($conn) && $conn instanceof mysqli) {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        $result = $conn->query('SELECT DATABASE()');
        $dbName = $result->fetch_row()[0] ?? null;

        if (!$dbName) {
            throw new RuntimeException('No database is selected.');
        }

        checkResult('Database connection', true, 'Connected successfully');
        checkResult('Selected database', true, $dbName);

        $result = $conn->query('SHOW TABLES');

        while ($row = $result->fetch_row()) {
            $table = $row[0];
            $quoted = '`' . str_replace('`', '``', $table) . '`';

            $columnsResult = $conn->query(
                "SHOW COLUMNS FROM {$quoted}"
            );
            $columns = $columnsResult->fetch_all(MYSQLI_ASSOC);

            $indexesResult = $conn->query(
                "SHOW INDEX FROM {$quoted}"
            );
            $indexes = $indexesResult->fetch_all(MYSQLI_ASSOC);

            $tables[] = [
                'name' => $table,
                'columns' => $columns,
                'indexes' => $indexes
            ];
        }

        checkResult(
            'Table inspection',
            true,
            count($tables) . ' table(s) found'
        );

    } else {
        throw new RuntimeException(
            'No supported database connection found. '
            . 'Expected PDO $pdo or MySQLi $conn in config.php.'
        );
    }

} catch (Throwable $e) {
    checkResult('Database diagnostic', false, $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PHP & MySQL Diagnostics</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f3f4f6;
    color: #111827;
    margin: 0;
    padding: 24px;
}
main {
    max-width: 1000px;
    margin: auto;
}
.card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 18px;
    margin-bottom: 16px;
    overflow-wrap: anywhere;
}
.ok { color: #047857; }
.fail { color: #b91c1c; }
table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 10px;
}
th, td {
    border: 1px solid #e5e7eb;
    padding: 8px;
    text-align: left;
    font-size: 13px;
}
th { background: #f9fafb; }
pre { white-space: pre-wrap; overflow-wrap: anywhere; }
</style>
</head>
<body>
<main>
<h1>PHP & MySQL Diagnostics</h1>
<p>Local development diagnostic report.</p>

<div class="card">
<h2>System</h2>
<p>PHP version: <?= h(PHP_VERSION) ?></p>
<p>PDO extension: <?= extension_loaded('pdo') ? 'Enabled' : 'Disabled' ?></p>
<p>PDO MySQL driver:
<?= extension_loaded('pdo_mysql') ? 'Enabled' : 'Disabled' ?></p>
<p>MySQLi extension:
<?= extension_loaded('mysqli') ? 'Enabled' : 'Disabled' ?></p>
</div>

<div class="card">
<h2>Connection checks</h2>
<?php foreach ($checks as $check): ?>
    <p class="<?= $check['ok'] ? 'ok' : 'fail' ?>">
        <strong><?= $check['ok'] ? 'PASS' : 'FAIL' ?>:</strong>
        <?= h($check['name']) ?> —
        <?= h($check['message']) ?>
    </p>
<?php endforeach; ?>
</div>

<?php foreach ($tables as $table): ?>
<div class="card">
<h2>Table: <?= h($table['name']) ?></h2>

<h3>Columns</h3>
<table>
<thead><tr>
<th>Column</th><th>Type</th><th>Null</th>
<th>Key</th><th>Default</th><th>Extra</th>
</tr></thead>
<tbody>
<?php foreach ($table['columns'] as $column): ?>
<tr>
<td><?= h($column['Field']) ?></td>
<td><?= h($column['Type']) ?></td>
<td><?= h($column['Null']) ?></td>
<td><?= h($column['Key']) ?></td>
<td><?= h($column['Default'] ?? 'NULL') ?></td>
<td><?= h($column['Extra']) ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h3>Indexes</h3>
<?php if (!$table['indexes']): ?>
<p>No indexes reported.</p>
<?php else: ?>
<table>
<thead><tr>
<th>Index</th><th>Column</th><th>Unique?</th>
</tr></thead>
<tbody>
<?php foreach ($table['indexes'] as $index): ?>
<tr>
<td><?= h($index['Key_name']) ?></td>
<td><?= h($index['Column_name']) ?></td>
<td><?= (int)$index['Non_unique'] === 0 ? 'Yes' : 'No' ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>
</div>
<?php endforeach; ?>

</main>
</body>
</html>
