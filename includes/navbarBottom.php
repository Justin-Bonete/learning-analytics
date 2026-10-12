


    <style>
        /* Hide the div when the screen width is 601px or greater */
        @media (min-width: 601px) {
            .container-fluidmobile {
                display: none;
            }
        }
        /* Hide the div when the screen width is 501px or smaller */
        @media (max-width: 600px) {
            .container-fluidbrowser {
                display: none;
            }
        }
    </style>
    
<div class="container-fluidmobile container-fluid position-relative p-0">
    <nav class="navbar sticky navbar-expand-lg navbar-dark px-3 py-3 py-lg-0 ">
        <a href="index.php" class="navbar-brand p-0">

            <h5 class="m-0 d-flex align-items-center">
            </h5>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars fa-xl"></span>
        </button>
        <div class="offcanvas offcanvas-end" id="navbarCollapse">
            <div class="offcanvas-header">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <div class="navbar-nav ms-auto py-0">

                <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
                        <center>
                        <h6 class="nav-item nav-link" style="color:green; border: 2px solid green; border-radius: 1vh; margin-left:-0.5vh;">
                            <?php echo $_SESSION['school_name']; ?>
                        </h6>
                        </center>
                            <hr>
                <?php }else{ ?>
                    <center>
                    <a href="#" class="nav-item nav-link d-lg-block d-lg-none d-xl-none" data-bs-toggle="modal" data-bs-target="#loginModal" style="margin-left:-0.5vh;">SIGN IN</a>
                </center>
                    <hr>
                <?php } ?>
                <center>
                    <a href="index.php" class="nav-item nav-link" style="margin-left:-0.5vh;">HOME</a><hr>
                    <a href="analytics.php" class="nav-item nav-link" style="margin-left:-0.5vh;">ANALYTICS</a><hr>
                <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
                    <?php if($_SESSION['priviledges'] == 'Teacher'){ ?>

                    <a href="teachers/dashboard.php" class="nav-item nav-link" style="margin-left:-0.5vh;">DASHBOARD</a><hr>
                    <?php }else{ ?>

                    <a href="users/dashboard.php" class="nav-item nav-link" style="margin-left:-0.5vh;">DASHBOARD</a><hr>
                    <?php } ?>
                <?php } ?>
                    <a href="faq.php" class="nav-item nav-link" style="margin-left:-0.5vh;">FAQ</a><hr>
                    <a href="contact.php" class="nav-item nav-link" style="margin-left:-0.5vh;">CONTACT US</a><hr>
                    </center>
                <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
                      <center>  <a href="logout.php" class="nav-item nav-link" style="margin-left:-0.5vh;">LOGOUT</a></center>
                      <hr>
                <?php } ?>
                </div>
            </div>
        </div>

    </nav>
</div>
<div class="container-fluidbrowser container-fluid position-relative p-0">
    <nav class="navbar sticky navbar-expand-lg navbar-dark px-3 py-3 py-lg-0 ">
        <a href="index.php" class="navbar-brand p-0">

            <h5 class="m-0 d-flex align-items-center">
            </h5>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars fa-xl"></span>
        </button>
        <div class="offcanvas offcanvas-end" id="navbarCollapse">
            <div class="offcanvas-header">
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body">
                <div class="navbar-nav ms-auto py-0">

                    <?php
                    // Check if the current page is not the desired page
                    if (strpos($_SERVER['REQUEST_URI'], '/login') === false && strpos($_SERVER['REQUEST_URI'], '/register') === false) {
                        ?>
                        <a href="#" class="nav-item nav-link d-lg-block d-lg-none d-xl-none" data-bs-toggle="modal"
                            data-bs-target="#loginModal">LOGIN / REGISTER</a>
                        <?php
                    } else {
                        ?>

                        <a href="adminLogin.php" class="nav-item nav-link d-lg-block d-lg-none d-xl-none">ADMINISTRATOR
                            LOGIN</a>

                        <?php
                    }
                    ?>


                    <a href="index.php" class="nav-item nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'index.php')
                        echo 'active'; ?>"><span  style="background-color:#156082; padding:1vh; border-radius:1vh; border:3px solid #0d445e; color:white;">HOME</span></a>
                    <a href="analytics.php" class="nav-item nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'analytics.php')
                        echo 'active'; ?>"><span  style="background-color:#156082; padding:1vh; border-radius:1vh; border:3px solid #0d445e; color:white;">ANALYTICS</span></a>

                <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>

                    <?php if($_SESSION['priviledges'] == 'Teacher'){ ?>

                    <a href="teachers/dashboard.php" class="nav-item nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'teacher/dashboard.php')
                        echo 'active'; ?>"><span  style="background-color:#156082; padding:1vh; border-radius:1vh; border:3px solid #0d445e; color:white;">DASHBOARD</span></a>
                    <?php }else{ ?>

                    <a href="users/dashboard.php" class="nav-item nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'users/dashboard.php')
                        echo 'active'; ?>"><span  style="background-color:#156082; padding:1vh; border-radius:1vh; border:3px solid #0d445e; color:white;">DASHBOARD</span></a>
                    <?php } ?>
                <?php } ?>
                    <a href="faq.php" class="nav-item nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'faq.php')
                        echo 'active'; ?>"><span  style="background-color:#156082; padding:1vh; border-radius:1vh; border:3px solid #0d445e; color:white;">FAQ</span></a>
                    <a href="contact_guest.php" class="nav-item nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'contact_guest.php')
                        echo 'active'; ?>"><span  style="background-color:#156082; padding:1vh; border-radius:1vh; border:3px solid #0d445e; color:white;">CONTACT US</span></a>
                </div>
            </div>
        </div>

    </nav>
</div>
