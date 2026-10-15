<?php
    include('includes/database_connection.php');

    if(isset($_POST['sendconcern'])){

        $message_attempts = 0;

        // Check if cookie exists and get its value, then increment or set to 1
        if (isset($_COOKIE['message_attempts'])) {
            $message_attempts = (int)$_COOKIE['message_attempts'] + 1;
        } else {
            $message_attempts = 1;
        }

        setcookie('message_attempts', $message_attempts, time() + 1800, '/'); // Expire after 30 minutes
        // Set a separate cookie for expiry time
        setcookie('message_attempts_expire', time() + 1800, time() + 1800, '/');
    }
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
    <title>Contact Us - <?php echo $SYS_name; ?></title>
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <script defer src="style/js/bootstrap.bundle.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="style/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/myStyle.css">
    <link rel="stylesheet" href="style/page-refresh.css?v=2">
    <link rel="stylesheet" href="style/app-polish.css?v=6">
    <link rel="icon" type="image/jpg" href="images/<?php echo $SYS_logo; ?>">
    <style>

        .header4 {
          min-height: 50vh;
          width: 100%;
          background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)),
            url(images/contact-us-4193401_640.jpg);
          background-position:100% 50%;
          background-size: cover;
          position: relative;
        }
        .map-responsive {
            overflow: hidden;
            padding-bottom: 95%;
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
    $guestname = $_POST['guestname'];
    $guestphone = $_POST['guestphone'];
    $guestemail = $_POST['guestemail'];
    $content = $_POST['content'];
    $ip_address = $_SERVER['REMOTE_ADDR'];

                    $sql = "INSERT INTO guest_inquries
                            (
                              full_name,
                              contact_number,
                              email_address,
                              ip_address,
                              message
                            ) 
                            VALUES
                            (
                              ?,
                              ?,
                              ?,
                              ?,
                              ?
                            )";

                    $query = mysqli_prepare($DB, $sql);
                    mysqli_stmt_bind_param($query, "sssss", $guestname, $guestphone, $guestemail, $ip_address, $content);
                    if (mysqli_stmt_execute($query)) {
                        $lastInsertId = mysqli_insert_id($DB);

                        if ($lastInsertId) {
                            showSweetAlertSucced22("Success!", "Your inquiry has been submitted!, we will notify you shortly thru your email or contact #. Thank you!", "success"); 
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
                     window.location.href = 'contact_guest.php';
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
                         window.location.href = 'contact_guest.php';
                       });
                   }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
                   </script>";
    }

        $saved_count = isset($_COOKIE['message_attempts']) ? (int)$_COOKIE['message_attempts'] : 0;
        $token_count = 3;
        $token_count = 3 - $saved_count;

        if (isset($_COOKIE['message_attempts'])) {
            $cookie_value = $_COOKIE['message_attempts'];

            // Get the approximate remaining time until cookie expires
            $cookie_expires = isset($_COOKIE['message_attempts_expire']) ? $_COOKIE['message_attempts_expire'] : 0;
            $current_time = time();
            $remaining_time = $cookie_expires - $current_time;

            // Format remaining time into minutes and seconds
            $minutes_remaining = floor($remaining_time / 60);
            $seconds_remaining = $remaining_time % 60;
        }

?>

<body class="contact-page">
    <?php include 'includes/page-loader.php'; ?>
    <?php
    include('includes/navbarTop.php');
    include('includes/public-navigation.php');
    ?>
    <style>

        .countdown {
            font-size: 15px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
    <section class="header4 public-page-hero">
        <div class="text-box">
            <h1>CONTACT US</h1>
            <p>Reach the Schools Division of Abra team with your question or concern.</p>
        </div>

    </section>

    <div class="container pt-5">
        <div class="row ">

            <div class="col-lg-6" style="display:none;">
                <h1 class="mb-3">Contact Us</h1>
                <p class="text-muted mb-3"> We really appreciate you taking the time to get in touch. Please fill in the form below, ensuring that you provide your correct email address and contact number, as we will use these to reply to you. Please make sure to inquire properly and refrain from misusing this page, as your IP address is monitored.
                </p>
                <?php if($token_count > 0){ ?>
                    <form action="" method="POST"  id="contactForm">
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="guestname" name="guestname" placeholder="Full Name" required />
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="guestphone" name="guestphone" placeholder="Phone Number" required />
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <input type="email" class="form-control" id="guestemail" name="guestemail" placeholder="Email Address" required />
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="input-group">
                                <textarea class="form-control" placeholder="Input the details." id="content" name="content" rows="10" required></textarea>
                            </div>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" id="sendconcern" name="sendconcern" class="btn btn-secondary btn-orange btn-block" style="color:black;" disabled>Send Inquiry</button>
                            <center><small style="font-weight:bold; color:#0452BA">You can send 3 inquries every 30 mins, remaining inquiry attempt count ( <?php echo $token_count; ?> ).</small></center>
                        </div>
                    </form>
                <?php }else{ ?>
                    <center>
                        <img src="images/waiting_image.jpg" width="400" height="400" style="border-radius:50%; border:1px solid #0452BA;" alt="Waiting Image" id="waitingImage" />
                    </center>

                        <!-- Countdown timer display -->
                        <div class="countdown" id="countdown">
                            <?php 
                            if (isset($minutes_remaining)) {
                                echo "Remaining Time: <span id='minutes'>$minutes_remaining</span> minutes <span id='seconds'>$seconds_remaining</span> seconds";
                            } else {
                                echo "Cookie 'message_attempts' is not set.";
                            }
                            ?>
                        </div>
                    <br>
                            <center><small style="font-weight:bold; color:#0452BA">Sorry, you have reached the maximum number of inquiry attempts. Please wait and try again after 30 minutes to submit your inquiry. Thank you for your understanding!</small></center>

                            <!-- Optional: Include JavaScript to update countdown timer -->
                            <script>
                                // JavaScript countdown timer
                                const minutesDisplay = document.getElementById('minutes');
                                const secondsDisplay = document.getElementById('seconds');
                                
                                let minutes = <?php echo isset($minutes_remaining) ? $minutes_remaining : 0; ?>;
                                let seconds = <?php echo isset($seconds_remaining) ? $seconds_remaining : 0; ?>;

                                function updateCountdown() {
                                    if (seconds > 0) {
                                        seconds--;
                                    } else {
                                        if (minutes > 0) {
                                            minutes--;
                                            seconds = 59;
                                        } else {
                                            // Countdown has finished, you can handle this event if needed
                                        }
                                    }

                                    // Update the countdown display
                                    minutesDisplay.textContent = minutes;
                                    secondsDisplay.textContent = seconds;

                                    // Update image border color based on seconds
                                    const image = document.getElementById('waitingImage');
                                    image.style.borderColor = seconds % 2 === 0 ? '#0452BA' : 'red'; // Change color every second
                                }

                                // Initial call to update countdown every second
                                setInterval(updateCountdown, 1000);
                            </script>
                            <!-- Optional: Include JavaScript to update border color dynamically -->
                            <script>
                                // JavaScript code to change border color every second
                                const image = document.getElementById('waitingImage');
                                let toggleColor = true;

                                setInterval(() => {
                                    if (toggleColor) {
                                        image.style.borderColor = 'red';
                                    } else {
                                        image.style.borderColor = '#0452BA';
                                    }
                                    toggleColor = !toggleColor;
                                }, 1000); // Change color every 1000ms (1 second)
                            </script>
                <?php } ?>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.getElementById('contactForm');
                    const phoneInput = document.getElementById('guestphone');
                    const emailInput = document.getElementById('guestemail');
                    const submitButton = document.getElementById('sendconcern');

                    const validateForm = () => {
                        const phoneValid = /^09\d{9}$/.test(phoneInput.value);
                        const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailInput.value);
                        submitButton.disabled = !(phoneValid && emailValid);
                    };

                    phoneInput.addEventListener('input', validateForm);
                    emailInput.addEventListener('input', validateForm);
                });
            </script>
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-4 col-xs-12 col-sm-12">
                        
                <h1 class="mb-3">Contact Us</h1>
                    <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="row">
                                <div class="col-md-2 col-xs-2">
                                <i class="fa fa-phone" style="transform: rotate(90deg); font-size:3vh;"></i>
                                </div>
                                <div class="col-md-8 col-xs-8" style="margin-left:1vh;">
                                <span>
                                    <h5 class="text-lead">09685083333</h5>
                                    <p class="text-muted">Call Us Directly</p>
                                </span>
                                </div>
                            </div>
                            </div>


                            <div class="col-md-12 col-xs-12">
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
                    </div>
                    <div class="col-md-8 col-xs-12 col-sm-12">
                        
                <h1 class="mb-3">Find Us On Map</h1>
                <div class="map-responsive">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126759.94591610515!2d120.52909462290513!3d17.612306611598893!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x338e5d39628063e9%3A0x4d1754e34af2539a!2sSchools%20Division%20Office%20of%20Abra%20Personnel%20Section!5e1!3m2!1sen!2sph!4v1738488222497!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                </div>
                    </div>
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