<?php
    require_once('../includes/database_connection.php'); 
?><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-blue elevation-4 role-sidebar">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
        <img src="../images/abra-gov-seal.png" alt="adminLogo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-bold">ADMIN PANEL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image mt-2">

                        <img src="../assets/uploads/default_profile.png" alt="Circle Image" class="circle-img">
            </div>
            <div class="info">
                <a href="#" data-toggle="modal" data-target="#editAdminProfile" class="d-block"><?php echo $_SESSION['fullname']; ?></a>
                <small class="text-light d-block">Administrator</small>
            </div>
        </div>
        <?php } ?>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item ">
                    <a href="dashboard.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'dashboard.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="schoolsubmitted.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'schoolsubmitted.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>
                            School Submitted
                        </p>
                    </a>
                </li>



                <li class="nav-header">MANAGE PROFILING</li>
                <!--
                <li class="nav-item">
                    <a href="manage_school.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_school.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            School List
                        </p>
                    </a>
                </li>
                    -->
                <li class="nav-item">
                    <a href="manage_teacher.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_teacher.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Teachers List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_school.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_school.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            School List
                        </p>
                    </a>
                </li>




                <li class="nav-header">LEARNERS LIST</li>



                <li class="nav-item">
                    <a href="manage_student.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_student.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Learners List
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="manage_shs.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_shs.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Senior High School
                        </p>
                    </a>
                </li>
                
                
                <li class="nav-item">
                    <a href="manage_kinder.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_kinder.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Kinder
                        </p>
                    </a>
                </li>
                







                <li class="nav-header">MANAGE LEARNERS SCORES</li>
                <li class="nav-item">
                    <a href="manage_scores.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_scores.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Learners Scores
                        </p>
                    </a>
                </li>
                <li class="nav-header">MANAGE LEARNERS GRADES</li>
                <li class="nav-item">
                    <a href="manage_grades.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_grades.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                             Learners Grades
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_grades11.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_grades11.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Grade 11
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_grades12.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_grades12.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Grade 12
                        </p>
                    </a>
                </li>

                <li class="nav-header">MANAGE PROCESSED DATA</li>

                <li class="nav-item">
                    <a href="manage_mps.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_mps.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-percentage"></i>
                        <p>
                            Mean Percentage Scores
                        </p>
                    </a>
                </li>

                <li class="nav-header">LEVEL OF PROFICIENCY</li>
                <li class="nav-item">
                    <a href="manage_lop.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_lop.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-level-up-alt"></i>
                        <p>
                            Grade 1 To 10 LOP
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_lopgrade11.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_lopgrade11.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-level-up-alt"></i>
                        <p>
                            Grade 11 LOP
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manage_lopgrade12.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_lopgrade12.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-level-up-alt"></i>
                        <p>
                            Grade 12 LOP
                        </p>
                    </a>
                </li>

            </ul>
            <br>
            <br>
            <br>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>