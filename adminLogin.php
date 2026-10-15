<!DOCTYPE html>
<html lang="en">
<?php
    require_once('includes/database_connection.php');
    session_start();

    if(isset($_SESSION['priviledges']) && $_SESSION['priviledges'] =='admin' && isset($_SESSION['logged']) && $_SESSION['logged'] =='True')
    {
        header('Location: admin/dashboard.php');
        exit();
    }
    if(isset($_SESSION['priviledges']) && $_SESSION['priviledges'] =='staff' && isset($_SESSION['logged']) && $_SESSION['logged'] =='True')
    {
        header('Location: staff/dashboard.php');
        exit();
    }

    $systemconfig = mysqli_query($DB, "Select * From settings WHERE id='1'");
    if (mysqli_num_rows($systemconfig) > 0) 
    { 
        while ($row = mysqli_fetch_assoc($systemconfig)) 
        {
        $SYS_logo = $row['SYS_logo'];
        $SYS_name = $row['SYS_name'];
        $SYS_background = $row['SYS_background'];
        $AB_title = $row['AB_title'];
        $AB_headerpicture = $row['AB_headerpicture'];
        $AB_officephoto = $row['AB_officephoto'];
        $NUP_title = $row['NUP_title'];
        $NUP_headerpicture = $row['NUP_headerpicture'];
        $CP_title = $row['CP_title'];
        $CP_headerpicture = $row['CP_headerpicture'];
        $CP_email = $row['CP_email'];
        $CP_contact = $row['CP_contact'];
        }
    }

    if(isset($_POST['adminlogin']))
    {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

         $checkresident = mysqli_query($DB, "SELECT * FROM admin WHERE username = '$username' AND password = '$password'");
            if (mysqli_num_rows($checkresident) > 0) 
            {
                while ($residentrecord = mysqli_fetch_assoc($checkresident)) 
                {
                    $_SESSION['logged'] = 'True'; //if false it means log out;
                    $_SESSION['priviledges'] = 'admin';
                    $_SESSION['user_id'] = $residentrecord['admin_ID'];
                    $_SESSION['firstName'] = $residentrecord['firstName'];
                    $_SESSION['middleName'] = $residentrecord['middleName'];
                    $_SESSION['lastName'] = $residentrecord['lastName'];
                    $_SESSION['fullname'] = $_SESSION['firstName'].' '.$_SESSION['middleName'].'. '.$_SESSION['lastName'];      
                    $_SESSION['username'] = $residentrecord['username'];
                    $_SESSION['password'] = $residentrecord['password'];            
                    $_SESSION['Profile_image'] = $residentrecord['profileImage'];       
                    $_SESSION['is_superadmin'] = $residentrecord['is_superadmin'];               
                }
                
                unset($_POST['adminlogin']);
                header('Location: admin/dashboard.php');
                exit();
            }
            else
            {
                    unset($_POST['adminlogin']);
                    $_SESSION['admin_loginresult'] = 'Username / Password is incorrect!';
                    header('Location: adminLogin.php');
                    exit();
                
            }
    }
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
                    <span><?php echo htmlspecialchars($SYS_name ?? 'CID Learning Analytics', ENT_QUOTES, 'UTF-8'); ?></span>
                </div>
                <div>
                    <h1>Leadership starts with <span>clear insight.</span></h1>
                    <p>Access the supervisor workspace for division-wide learning analytics and school reporting.</p>
                </div>
                <div class="admin-login-mark"><i class="fas fa-shield-alt" aria-hidden="true"></i> Secure access for authorized administrators</div>
            </section>

            <section class="admin-login-form-wrap" aria-labelledby="adminLoginTitle">
                <h2 id="adminLoginTitle">Supervisor sign in</h2>
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