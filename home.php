<?php
include('includes/database_connection.php');
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - <?php echo htmlspecialchars($SYS_name ?? 'CID Learning Analytics', ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <script defer src="style/js/bootstrap.bundle.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style/myStyle.css">
    <link rel="stylesheet" href="style/about-page.css">
    <link rel="stylesheet" href="style/page-refresh.css?v=2">
    <link rel="stylesheet" href="style/app-polish.css?v=6">
    <link rel="icon" type="image/jpg" href="images/<?php echo $SYS_logo; ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .header2 {
            min-height: 50vh;
            width: 100%;
            background-image: linear-gradient(rgba(4, 9, 30, 0.5), rgba(4, 9, 30, 0.5)),
                url(images/<?php echo $AB_headerpicture; ?>);
            background-position: center 33%;
            background-size: cover;
            position: relative;
        }
        
        /* Fade-in animation */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1.5s ease-in forwards;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        /* Center content styling */
        .centered-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
        }
        
        .feature-list {
            text-align: left;
            display: inline-block;
            margin: 20px 0;
        }
    </style>
</head>

<?php
include 'includes/modals.php';
?>

<body class="about-page">
 <?php include 'includes/page-loader.php'; ?>
        <?php
            include('includes/navbarTop.php');
            include('includes/public-navigation.php');
        ?>
    <section class="header2">
        <?php
        include('js/JSFunctions.php');
        ?>

        <!-- Removed the text-box with About Us title -->
    </section>

    <div class="container pt-2 pb-5 fade-in">
        <div class="row justify-content-center" style="margin-top:5vh;">
            <div class="col-md-10">
                <div class="centered-content">
                    <h2 class="my-3">SDO ABRA LEARNING ANALYTICS</h2>
                    <p><b>Welcome to the Learning Analytics Platform of the Schools Division of Abra!</b></p>
                    <p style="text-align: justify;">
                        Our goal is to enhance educational outcomes by leveraging data-driven insights and innovative technology. This platform is designed to support educators, administrators, and stakeholders in making informed decisions that improve the learning experience for all students.
                    </p>
                    
                    <h4 class="mt-4">Key Features</h4>
                    
                    <div class="feature-list">
                        <ul>
                            <li>Comprehensive Data Collection: We gather detailed data on learners' profiles, grades, quarterly summative test scores, teachers' profiles, and schools' profiles.</li>
                            <li>Advanced Analytics: Our decision-tree algorithm generates data-driven insights and suggested interventions tailored to the specific needs of each school.</li>
                            <li>User-Friendly Interface: The platform is designed to be intuitive and accessible, ensuring that users can easily navigate and utilize the system.</li>
                            <li>Continuous Improvement: We prioritize user feedback and continuously refine our system to enhance usability and effectiveness.</li>
                        </ul>
                    </div>

                    <div class="py-3">
                        <a href="https://www.depedabra.com/" class="btn btn-outline-primary">Visit Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>