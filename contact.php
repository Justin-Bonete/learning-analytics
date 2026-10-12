<?php
include('includes/database_connection.php');
?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<?php
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
    <title>Contact - <?php echo htmlspecialchars($SYS_name ?? 'CID Learning Analytics', ENT_QUOTES, 'UTF-8'); ?></title>

    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <script defer src="style/js/bootstrap.bundle.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="style/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/myStyle.css">
    <link rel="stylesheet" href="style/page-refresh.css">
    <link rel="stylesheet" href="style/app-polish.css?v=5">
    <link rel="icon" type="image/jpg" href="images/<?php echo $SYS_logo; ?>">

    <style>

.header4 {
  min-height: 50vh;
  width: 100%;
  background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)),
    url(images/<?php echo $CP_headerpicture; ?>);
  background-position: 25% 100%;
  background-size: cover;
  position: relative;
}
        .map-responsive {
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
            height: 0;
        }

        .map-responsive iframe {
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            position: absolute;
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        @media (min-width: 768px) {
            .contact-info {
                flex-direction: row;
            }

            .contact-info h5 {
                margin: 0 20px;
            }
        }

        .contact-col {
            flex-basis: 48%;
            margin-bottom: 30px;
        }

        .contact-col div {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
        }

        .contact-col div .fa {
            font-size: 28px;
            color: #d78219;
            margin: 10px;
            margin-right: 30px;
        }

        .contact-col div p {
            padding: 0;
        }

        .contact-col div h5 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #555;
            font-weight: 400;
        }
    </style>

</head>

<?php
include 'includes/modals.php';


if(isset($_POST['sendconcern'])){
    $title_concern = $_POST['title_concern'];
    $content = $_POST['content'];
    $resident_id = $_SESSION['user_id'];

                    $sql = "INSERT INTO inquries
                            (
                              user_id,
                              title_concern,
                              content
                            ) 
                            VALUES
                            (
                              ?,
                              ?,
                              ?
                            )";

                    $query = mysqli_prepare($DB, $sql);
                    mysqli_stmt_bind_param($query, "sss", $resident_id, $title_concern, $content);

                    if (mysqli_stmt_execute($query)) {
                        $lastInsertId = mysqli_insert_id($DB);

                        if ($lastInsertId) {
                            
                            showSweetAlertSucced22("Success!", "Your concern has been submitted!, we will notify you shortly. Thank you!", "success"); 
                        }else{

                            showSweetAlertSucced22("Error!", "Failed to submit your concern, Please try again later.", "error"); 
                        }
                    }
    }





    function showSweetAlertSucced22($title, $message, $type) {
               echo "
               <script>
               setTimeout(function() {
                   Swal.fire({
                       title: '$title',
                       text: '$message',
                       icon: '$type',
                       confirmButtonText: 'OK'
                   }).then(function() {
                     window.location.href = 'contact.php';
                   });
               }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
               </script>";
    }
    function showSweetAlertFailed22($title, $message, $type) {
                   echo "
                   <script>
                   setTimeout(function() {
                       Swal.fire({
                           title: '$title',
                           text: '$message',
                           icon: '$type',
                           confirmButtonText: 'OK'
                       }).then(function() {
                         window.location.href = 'contact.php';
                       });
                   }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
                   </script>";
    }
?>

<body class="contact-page">
    <?php
    include('includes/navbarTop.php');
    include('includes/public-navigation.php');
    ?>

    <section class="header4 public-page-hero">
        <div class="text-box">
            <h1>INQUIRIES</h1>
            <p>Contact the Schools Division of Abra team for assistance and information.</p>
        </div>

    </section>

    <div class="container pt-5">
        <div class="row ">

            <div class="col-lg-6">
                <h1 class="mb-3">Reach Us</h1>
                <p class="text-muted mb-3">We really appreciate you taking the time to get in touch. Please fill in the
                    form below. After sending your inquiry please wait for us to answer and we will notify you shortly.</p>

                <form action="#" method="post">


                    <div class="form-group mb-3">
                        <div class="input-group">
                            <select id="title_concern" name="title_concern" class="form-control select2">
                                <option value="Payments">Payments</option>
                                <option value="Maintenance">Maintenance</option>
                                <option value="Move Out">Move Out</option>
                                <option value="Move In">Move In</option>
                                <option value="Other Concern">Other ( Please specify on the message )</option>

                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="input-group">

                            <textarea class="form-control" placeholder="Input the details of your concern / inquiry." id="content" name="content" rows="10"
                                required></textarea>
                        </div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" id="sendconcern" name="sendconcern" class="btn btn-secondary btn-orange btn-block" style="background-color:#1C6EBA; color:White; font-weight:bold;">Send Inquiry</button>
                    </div>

                </form>

            </div>

            <div class="col-lg-6">
                    <div class="row">
                            <div class="col-md-4 col-xs-12">
                                <div class="row">
                                <div class="col-md-2 col-xs-2">
                                <i class="fa fa-phone" style="transform: rotate(90deg); font-size:3vh;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8" style="margin-left:1vh;">
                                <span>
                                    <h5 class="text-lead">09052847626</h5>
                                    <p class="text-muted">Call Us Directly</p>
                                </span>
                                </div>
                            </div>
                            </div>


                            <div class="col-md-8 col-xs-12">
                                <div class="row">
                                <div class="col-md-2 col-xs-2">
                                <i class="fa fa-envelope" style=" font-size:3vh;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8">
                                <span>
                                    <h5 class="text-lead">sdoabra.cid@deped.gov.ph</h5>
                                    <p class="text-muted">Email us your concern</p>
                                </span>
                                </div>
                            </div>
                            </div>

                    </div>

                <div class="map-responsive">
                   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d241.35721382135017!2d121.04639265859167!3d14.558259558061367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397c8f7be73a749%3A0xf7d91fa8eab0cf7f!2sJacinto%20Ext%2C%20Makati%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1716078078285!5m2!1sen!2sph" width="600" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>
            </div>
        </div>
    </div>


    </div>
<br><br><br>
    <?php
    include('footer.php');

    ?>
</body>
</html>