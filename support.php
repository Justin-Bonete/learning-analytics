<?php
include('includes/database_connection.php');
$systemconfig = mysqli_query($DB, "SELECT * FROM settings WHERE id='1'");
$SYS_logo = 'abra-gov-seal.png';
$SYS_name = 'CID Learning Analytics';

if ($systemconfig && mysqli_num_rows($systemconfig) > 0) {
    $settings = mysqli_fetch_assoc($systemconfig);
    $SYS_logo = $settings['SYS_logo'] ?: $SYS_logo;
    $SYS_name = $settings['SYS_name'] ?: $SYS_name;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support - <?php echo htmlspecialchars($SYS_name, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <script defer src="style/js/bootstrap.bundle.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css">
    <link rel="stylesheet" href="style/myStyle.css">
    <link rel="stylesheet" href="style/page-refresh.css?v=2">
    <link rel="stylesheet" href="style/app-polish.css?v=6">
    <link rel="icon" type="image/jpg" href="images/<?php echo rawurlencode(basename($SYS_logo)); ?>">
</head>
<?php include 'includes/modals.php'; ?>
<body class="support-page">
    <?php include 'includes/page-loader.php'; ?>
    <?php
    include('includes/navbarTop.php');
    include('includes/public-navigation.php');
    ?>
    <section class="public-page-hero" aria-labelledby="supportHeading">
        <div class="public-page-hero-inner">
            <span class="about-section-kicker">Schools Division of Abra</span>
            <h1 id="supportHeading">Support</h1>
            <p>Support resources and guidance will be added here.</p>
        </div>
    </section>
    <main class="container py-5">
        <div class="card border-0 shadow-sm mx-auto" style="max-width: 720px;">
            <div class="card-body p-4 p-md-5 text-center">
                <h2 class="h4 mb-3">How can we help?</h2>
                <p class="text-muted mb-4">This page is ready for support information, guides, and answers to common issues.</p>
                <a class="btn btn-primary" href="contact_guest.php">Contact us</a>
            </div>
        </div>
    </main>
    <?php include('footer.php'); ?>
</body>
</html>
