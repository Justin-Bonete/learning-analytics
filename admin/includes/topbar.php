<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-blue navbar-light accent-blue role-dashboard-topbar">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">

        <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
            <a class="nav-link role-profile-trigger" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                <span class="role-profile-name"><?php echo htmlspecialchars((string) ($_SESSION['fullname'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></span>
                <img src="../assets/uploads/default_profile.png" alt="" aria-hidden="true" class="circle-img role-profile-avatar">
                <i class="fas fa-chevron-down role-profile-caret" aria-hidden="true"></i>
            </a>
        <?php } ?>  
            <div class="dropdown-menu dropdown-menu dropdown-menu-right">
                <span class="dropdown-item dropdown-header">
                    <h6><?php echo htmlspecialchars((string) ($_SESSION['fullname'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></h6>
                </span>
                <hr>
                
                <a href="#" class="dropdown-item active-blue" data-toggle="modal" data-target="#editProfile">Edit
                    Profile</a>
                <hr>
                <a href="changepassword.php" class="dropdown-item active-blue">Change Password</a>
                <hr>
                <a href="logout.php" class="dropdown-item active-blue">Logout</a>
                
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->