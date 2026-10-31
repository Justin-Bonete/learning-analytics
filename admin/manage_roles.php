<?php
require_once('../includes/database_connection.php');
$DB = $conn;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (($_SESSION['logged'] ?? '') !== 'True' || ($_SESSION['priviledges'] ?? '') !== 'admin') {
    header('Location: ../adminLogin.php');
    exit();
}

$accounts = $DB->query("
    SELECT
        COALESCE(NULLIF(TRIM(CONCAT_WS(' ', firstName, middleName, lastName)), ''), username) AS account_name,
        username,
        CASE
            WHEN LOWER(TRIM(username)) IN ('gryanlyle.navarro@deped.gov.ph', 'dev@deped.gov.ph') THEN 'Administrator'
            ELSE 'Supervisor'
        END AS role
    FROM admin
    UNION ALL
    SELECT teacher_name AS account_name, email AS username, 'Teacher' AS role
    FROM teachers_profiling
    UNION ALL
    SELECT school_name AS account_name, email AS username, 'School' AS role
    FROM schools
    ORDER BY account_name, username
");

include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>Account Roles</h1>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white">
                    <thead>
                        <tr>
                            <th scope="col">Account</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($account = $accounts->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars((string) $account['account_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars((string) $account['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars((string) $account['role'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
<?php include('includes/footer.php'); ?>