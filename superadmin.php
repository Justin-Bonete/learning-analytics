<!DOCTYPE html>
<html lang="en">
<?php 
require_once('includes/databasse_copnnection.php');
session_start();

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Login - <?php echo htmlspecialchars($SYS_name ?? 'CID Learning Analytics', ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <script defer src="style/js/bootstrap.bundle.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style/myStyle.css">
    <link rel="stylesheet" href="style/page-refresh.css?v=2">
    <link rel="stylesheet" href="style/app-polish.css?v=6">
    <link rel="icon" type="image/jpg" href="images/<?php echo rawurlencode(basename($SYS_logo ?? 'abra-gov-seal.png')); ?>">
</head>
<body class="admin-login-page">
    <?php include 'includes/page-loader.php'; ?>
    <main class="admin-login-shell">
        <a class="admin-login-back" href="index.php"><i class="fas fa-arrow-left" aria-hidden="true"></i> Back to the public site</a>
        <div class="admin-login-layout">
            <section class="admin-login-intro" aria-label="Supervisor portal">
                <div class="admin-login-brand">
                    <img src="images/<?php echo rawurlencode(basename($SYS_logo ?? 'abra-gov-seal.png')); ?>" alt="Schools Division of Abra seal">
                    <span>Learning Analytics</span>
                </div>
                <div>
                    <h1>Leadership starts with <span>clear insight.</span></h1>
                    <p>Access the supervisor workspace for division-wide learning analytics and school reporting.</p>
                </div>
                <div class="admin-login-mark"><i class="fas fa-shield-alt" aria-hidden="true"></i> Secure access for authorized administrators</div>
            </section>

            <section class="admin-login-form-wrap" aria-labelledby="adminLoginTitle">
                <h2 id="adminLoginTitle">Administrator sign in</h2>
                <p>Enter your administrator credentials to continue.</p>
                <?php if (isset($_SESSION['admin_loginresult']) && $_SESSION['admin_loginresult'] !== '') { ?>
                    <div class="admin-login-error" role="alert">
                        <?php echo htmlspecialchars($_SESSION['admin_loginresult'], ENT_QUOTES, 'UTF-8'); ?>
                    </div>
                    <?php $_SESSION['admin_loginresult'] = ''; ?>
                <?php } ?>
                <form action="" method="post">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" class="form-control" placeholder="Username" name="username" autocomplete="username" required>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                        <input type="password" class="form-control" placeholder="Password" name="password" autocomplete="current-password" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn admin-login-submit" name="adminlogin">Sign in <i class="fas fa-arrow-right ms-2" aria-hidden="true"></i></button>
                    </div>
                </form>
                <p class="mt-4 mb-0 text-center"><a class="admin-login-public-link" href="index.php">Return to the public site</a></p>
            </section>
        </div>
    </main> 
</body>
</html>