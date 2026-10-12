<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">

<!-- Include Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Mobile Responsive Styles */
    .header-container {
        background-color: #8ed973 !important;
        padding: 1vh !important;
    }
    
    .brand-logo {
        width: 7vh !important;
        height: 7vh !important;
        max-width: 60px;
        max-height: 60px;
        min-width: 50px;
        min-height: 50px;
    }
    
    @media (min-width: 768px) {
        .brand-logo {
            width: 8vh !important;
            height: 8vh !important;
        }
    }
    
    .header-title {
        font-size: 1.6vh !important;
        line-height: 1.2;
        margin: 0;
        word-wrap: break-word;
    }
    
    @media (min-width: 576px) {
        .header-title {
            font-size: 1.8vh !important;
        }
    }
    
    @media (min-width: 768px) {
        .header-title {
            font-size: 2.2vh !important;
        }
    }
    
    @media (min-width: 992px) {
        .header-title {
            font-size: 2.5vh !important;
        }
    }
    
    @media (min-width: 1200px) {
        .header-title {
            font-size: 3vh !important;
        }
    }
    
    .mobile-stack {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-end;
        gap: 0.8rem;
        flex-wrap: nowrap;
    }
    
    .notification-badge {
        font-size: 0.7rem;
        position: absolute;
        top: -5px;
        right: -5px;
    }
    
    .nav-icon {
        font-size: 1.3rem;
    }
    
    @media (min-width: 768px) {
        .nav-icon {
            font-size: 1.1rem;
        }
    }
    
    .circle-img {
        width: 38px !important;
        height: 38px !important;
        border-radius: 50%;
        object-fit: cover;
    }
    
    @media (min-width: 768px) {
        .circle-img {
            width: 40px !important;
            height: 40px !important;
        }
    }
    
    .login-btn {
        background-color: #156082 !important;
        padding: 0.8vh 1.2vh !important;
        border-radius: 0.8vh !important;
        border: 2px solid #0d445e !important;
        color: white !important;
        font-size: 0.8rem;
        white-space: nowrap;
    }
    
    @media (min-width: 576px) {
        .login-btn {
            font-size: 0.85rem;
            padding: 1vh 1.5vh !important;
        }
    }
    
    .dropdown-menu {
        z-index: 9999 !important;
        max-width: 300px;
        font-size: 0.9rem;
    }
    
    .user-name-mobile {
        display: none;
    }
    
    @media (min-width: 768px) {
        .user-name-mobile {
            display: inline;
        }
    }
    
    /* Ensure all columns maintain their layout on mobile */
    .logo-col {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }
    
    .title-col {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 0.5rem;
    }
    
    .user-col {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    
    /* Mobile-specific adjustments */
    @media (max-width: 767px) {
        .header-container {
            padding: 0.8vh !important;
        }
        
        .header-title {
            font-size: 1.4vh !important;
            line-height: 1.1;
        }
        
        .mobile-stack {
            gap: 0.5rem;
        }
        
        .login-btn {
            font-size: 0.75rem;
            padding: 0.6vh 1vh !important;
        }
        
        .brand-logo {
            width: 6vh !important;
            height: 6vh !important;
        }
    }
    
    /* Very small mobile devices */
    @media (max-width: 375px) {
        .header-title {
            font-size: 1.2vh !important;
        }
        
        .login-btn {
            font-size: 0.7rem;
            padding: 0.5vh 0.8vh !important;
        }
    }
</style>

<div class="container-fluid header-container">
    <div class="row gx-1 align-items-center">
        <!-- Logo Column - Always 2 columns -->
        <div class="col-2 col-md-2 col-lg-2 logo-col">
            <img src="images/abra-gov-seal.png" alt="Abra Logo" class="brand-logo img-circle elevation-3">
        </div>
        
        <!-- Title Column - Always 8 columns -->
        <div class="col-8 col-md-8 col-lg-8 title-col">
            <h4 class="header-title text-dark text-center">
                <b>COMPREHENSIVE LEARNING ANALYTICS PLATFORM IN THE SCHOOLS DIVISION OF ABRA</b>
            </h4>
        </div>
        
        <!-- User Section - Always 2 columns -->
        <div class="col-2 col-md-2 col-lg-2 user-col">
            <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
                <?php
                if (isset($_SESSION['priviledges'])) 
                {
                    if ($_SESSION['priviledges'] == 'admin') {
                        echo '<script>window.location.href = "admin/dashboard.php";</script>';
                        exit();
                    } 
                }
                ?>

                <div class="mobile-stack">
                    <!-- Notification Bell -->
                    <div class="dropdown">
                        <a class="nav-link position-relative p-1" data-bs-toggle="dropdown" href="#" style="color: black;">
                            <i class="far fa-bell nav-icon"></i>
                            <?php
                                $userid = $_SESSION['user_id'];
                                $notif_count = 0;
                                $notifcounter = mysqli_query($DB, "SELECT * FROM notification WHERE n_userid = '$userid' and n_status = 'Unread'");
                                if (mysqli_num_rows($notifcounter) > 0) 
                                { 
                                    while ($rowcount = mysqli_fetch_assoc($notifcounter)) 
                                    {
                                        $notif_count++;
                                    }
                                }
                            ?>
                            <?php if($notif_count > 0): ?>
                                <span class="badge badge-danger notification-badge"><?php echo $notif_count; ?></span>
                            <?php endif; ?>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <span class="dropdown-item dropdown-header text-center">
                                <?php echo $notif_count; ?> Notification<?php echo $notif_count != 1 ? 's' : ''; ?>
                            </span>
                            <div class="dropdown-divider"></div>
                            <?php if($notif_count != 0): ?>
                                <?php
                                $notifcounter = mysqli_query($DB, "SELECT * FROM notification WHERE n_userid = '$userid' and n_status = 'Unread'");
                                if (mysqli_num_rows($notifcounter) > 0) 
                                { 
                                    while ($rowcount = mysqli_fetch_assoc($notifcounter)) 
                                    {
                                        $notif_id = $rowcount['n_id'];
                                        $dateString1 = $rowcount['Submitted_date'];
                                        $timestamp1 = strtotime($dateString1);
                                        $formattedDate1 = date("M j, Y g:i A", $timestamp1);
                                        $inquiry = $rowcount['n_content'];
                                        ?>
                                        <a href="#" class="dropdown-item">
                                            <small class="text-danger">
                                                <b><i class="fa fa-bell text-dark me-1"></i><?php echo $inquiry; ?></b><br>
                                                <?php echo $formattedDate1; ?>
                                            </small>
                                        </a>
                                        <?php
                                    }
                                }
                                ?>
                            <?php else: ?>
                                <div class="text-center p-2">
                                    <small class="text-muted">No Notification Available</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- User Profile -->
                    <div class="dropdown">
                        <a class="nav-link d-flex align-items-center p-1" data-bs-toggle="dropdown" href="#" style="color: black;">
                            <img src="assets/uploads/default_profile.png" alt="Profile" class="circle-img">
                            <span class="user-name-mobile ms-1"><?php echo $_SESSION['school_name']; ?></span>
                            <i class='fas fa-angle-down ms-1'></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-end">
                            <span class="dropdown-item dropdown-header text-center">
                                <h6 class="mb-0"><?php echo $_SESSION['school_name']; ?></h6>
                            </span>
                            <div class="dropdown-divider"></div>
                            <div class="text-center">
                                <a href="logout.php" class="dropdown-item text-danger">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>
                <div class="mobile-stack">
                    <?php
                    // Check if the current page is not the desired page
                    if (strpos($_SERVER['REQUEST_URI'], '/login') === false && strpos($_SERVER['REQUEST_URI'], '/register') === false) {
                        ?>
                        <a class="btn login-btn" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            LOGIN
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="btn login-btn" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                            LOGIN
                        </a>
                        <?php
                    }
                    ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
