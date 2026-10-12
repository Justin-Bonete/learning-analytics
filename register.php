<?php 
    require_once('includes/database_connection.php'); 

    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'admin/src/Exception.php';
    require 'admin/src/PHPMailer.php';
    require 'admin/src/SMTP.php';
    $mail = new PHPMailer();
    
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
    

    $registration_message = '';
    $registration_error = '';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create an Account</title>
        <link rel="stylesheet" href="style/css/bootstrap.min.css">
        <script defer src="style/js/bootstrap.bundle.js"></script>
        <!-- Icon Font Stylesheet -->
        <link href="style/fontawesome/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style/myStyle.css">
        <link rel="stylesheet" href="style/app-polish.css?v=5">
    <link rel="icon" type="image/jpg" href="images/<?php echo $SYS_logo; ?>">
        <style>
            .wrapperReg {
            border-top: 03px solid #0F52BA;
            }
            .wrapperReg a {
            text-decoration: none;
            color: #0F52BA;
            }
            .container-box {
            padding-top: 120px;
            padding-bottom: 50px;
            }
            @media (max-width: 991.98px) {
            .container-box {
            padding-top: 10px;
            padding-bottom: 25px;
            }
            }
            /* Style for the radio buttons */
            .form-check-input[type="radio"] {
            width: 1.2em;
            height: 1.2em;
            margin-top: 0.25em;
            margin-right: 0.5em;
            border-color: #343a40;
            }
            /* Style for the selected radio button */
            .form-check-input[type="radio"]:checked {
            background-color: #0F52BA;
            border-color: #0F52BA;
            }
            /* Style for the radio button label */
            .form-check-label {
            color: #343a40;
            }
        </style>
    </head>
    <?php
        include 'includes/modals.php';

            if(isset($_POST['registernow']))
    {
        $validation = 1; // 1 means proceed and 0 means not.

        $schoolname = $_POST['schoolname']; 
        $schoolid = $_POST['schoolid']; 
        $emailaddress = $_POST['email'];
        $checkpass = $_POST['password123']; // password
        $confirmpass = $_POST['confirmPassword123']; // confirm password
        $password = md5($_POST['password123']);
        $rawpassword = $_POST['password123'];
        $fullanme = $schoolname;
        $inherit_emailaddress = $emailaddress;

        $facilities = $_POST['facilities'];
        $internet = $_POST['internet'];
        $accessibility = $_POST['accessibility'];
        $district = $_POST['district'];


        $checkererker = 0;
        $checkresident = mysqli_query($DB, "SELECT * FROM schools WHERE email = '$emailaddress'");
        if (mysqli_num_rows($checkresident) > 0) 
        {
            $checkererker++;
        }

        if($checkererker == 0){
        if ($checkpass == $confirmpass) {
            if ($validation == 1) 
            {

                try 
                {
                    $sql = "INSERT INTO schools
                            (
                              school_name,
                              school_id,
                              email,
                              password,
                              accessibility,
                              facilities,
                              internetconnectivity,
                              district
                            ) 
                            VALUES
                            (
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?,
                              ?
                            )";

                    $query = mysqli_prepare($DB, $sql);
                    mysqli_stmt_bind_param($query, "ssssssss", $schoolname, $schoolid, $emailaddress, $password, $accessibility, $facilities, $internet, $district);

                    if (mysqli_stmt_execute($query)) {
                        $lastInsertId = mysqli_insert_id($DB);

                        if ($lastInsertId) {
                                                   
                        $message = '
                            <html>
                                <body>
                                    <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px;">
                                        <h2 style="color: #2c3e50; text-align: center;">Welcome to ' . $SYS_name . '</h2>
                                        <p style="color: #333; font-size: 16px;">Dear School Administrator,</p>
                                        <p style="color: #333; font-size: 16px;">Thank you for registering your school with us.</p>
                                        <p style="color: #333; font-size: 16px;">To complete the registration process and activate your school’s account, please verify your account by clicking the link below:</p>
                                        <div style="text-align: center; margin: 20px 0;">
                                            <a href="http://localhost/Navarro-MIT/validate-user.php?email=' . $emailaddress . '" style="background-color: #2980b9; color: #fff; padding: 12px 20px; font-size: 18px; text-decoration: none; border-radius: 5px; display: inline-block;">VERIFY YOUR ACCOUNT</a>
                                        </div>
                                        <p style="color: #333; font-size: 16px;">Once verified, your account will be reviewed by our administrator.</p>
                                        <p style="color: #333; font-size: 16px;">Please allow some time for final approval. You will receive a confirmation email once your account is fully activated.</p>
                                        <p style="color: #333; font-size: 16px;">If you have any questions or need assistance, feel free to contact us.</p>
                                        <br>
                                        <p style="color: #333; font-size: 16px;">Best regards,</p>
                                        <p style="color: #333; font-size: 16px; font-weight: bold;">' . $SYS_name . ' Management</p>
                                    </div>
                                </body>
                            </html>';

                    
                            try 
                            {   
                                $fullname = $fullanme;
                                $cust_email = $emailaddress;
                                $cust_name = $fullname;
                    
                                $mail->IsSMTP();
                                
                                $mail->Mailer = "smtp"; //change to mail if not working
                                
                                $mail->SMTPDebug  = false;  
                                
                                $mail->SMTPAuth   = true; //change to false if not working
                                
                                $mail->SMTPSecure = "tls";
                                
                                $mail->Port       = 587;
                                
                                $mail->Host       = "smtp.gmail.com";
                                
                                  $mail->Username   = "rjq.software.tester@gmail.com"; //retain the gmail here.
                                  $mail->Password   = "nhnavzxoojdmzwax";       //nhnavzxoojdmzwax this is the app password for the email to work.
                                  $mail->IsHTML(true);
                                  $mail->AddAddress($cust_email, $cust_name);
                                  $mail->SetFrom("rjq.software.tester@gmail.com", $SYS_name); //when in hosting change this the email of web.z
                                  $mail->AddReplyTo("rjq.software.tester@gmail.com", $SYS_name);//when in hosting change this the email of web.z
                                
                                $mail->Subject = 'Account Verification';
                                
                                $EMAIL_MESSAGE = $message;
                                
                                $mail->MsgHTML($EMAIL_MESSAGE); 
                                
                                if(!$mail->Send()) 
                                {
                                  $errormessage =  "Error while sending Email!";
                                  var_dump($mail);
                                } 
                                else 
                                {
                                            showSweetAlertSucced22("Success!", "Thank you for joining with us! Please verify your account by clicking the link that was sent to your email inbox.", "success"); 
                                } 
                            } 
                            catch (Exception $e) 
                            {
                            }

                        } else {
                            $registration_error .= 'Something happened! Please try again.';
                        }
                    } else {
                        $registration_error .= 'An error occurred while registering your account: ' . mysqli_error($DB);
                    }

                    mysqli_stmt_close($query);
                } catch (PDOException $e) {
                    $registration_error .= 'An error occurred while registering your account: ' . $e->getMessage();
                }
            }
        } else {
            $registration_error .= 'Password confirmation is incorrect!';
        }
    }else{

            $registration_error .= 'Account is already existing!';
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
                     window.location.href = 'index.php';
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
                         window.location.href = 'index.php';
                       });
                   }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
                   </script>";
    }
        ?>
    <body class="registration-page">
        <?php
            include('includes/navbarTop.php');
            ?>
        
    <style>
    .header1 {
      min-height: 100vh;
      width: 100%;
      background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)),
        url(images/argonresidences_bg.jpg);
      background-position: center;
      background-size: cover;
      position: relative;
    }
    </style>
        <section class="header1">
            <?php
                include('includes/navbarBottom.php');
                ?>
            <div class="container-fluid container-box">
                <div class="row justify-content-center mx-auto">
                    <div class="col-md-10 col-lg-6 bg-white m-auto rounded wrapperReg">
                        <h2 class="text-center pt-3">Create School account</h2>
                        <hr>
                         <?php if($registration_message != '' || $registration_error != '') { ?>
                            <?php
                                    $labelcolor = "green";
                                    if($registration_message != '')
                                    { 
                                        $labelcolor = 'green'; 
                                    }

                                    if($registration_error != '')
                                    { 
                                        $labelcolor = 'red'; 
                                    }
                            ?>
                        <center>
                            <small style="font-size:2vh; color:<?php echo $labelcolor; ?>;">
                                <?php if($registration_error != '') { echo $registration_error; } ?>
                            </small>
                        </center>
                        <hr>
                        <?php } ?>

                        <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="row mx-0">
                                <h4>School Details</h4>
                                <div class="col-md-8">
                                    <div class="form-group mb-3">
                                        <label class="form-label">School Name <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="schoolname" name="schoolname" placeholder="Enter Complete School Name" value="<?php if(isset($_POST['schoolname'])){ echo $_POST['schoolname']; } ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
    <div class="form-group mb-3">
        <label class="form-label">District <span style="color:red;">*</span></label>
        <select class="form-control" id="district" name="district" required>
            <option value="">Select District</option>
            <?php
            $districts = ["Bangued", "Bucay", "La Paz", "Lagangilang", "Luba", "Dolores", "Pidigan", "San Juan", "Pilar", "Sallapadan"];
            foreach ($districts as $district) {
                $selected = (isset($_POST['district']) && $_POST['district'] == $district) ? 'selected' : '';
                echo "<option value='$district' $selected>$district</option>";
            }
            ?>
        </select>
    </div>
</div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">School ID <span style="color:red;">*</span></label>
                                        <input type="text" class="form-control" id="schoolid" name="schoolid" placeholder="Enter Your Valid School ID number" value="<?php if(isset($_POST['schooolid'])){ echo $_POST['schooolid']; } ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Email Address <span style="color:red;">* (Deped 365 outlook email)</span></label>
                                        <input type="text" class="form-control" id="email123123" placeholder="Enter Deped 365 outlook email" name="email" required onkeyup="validateEmail(this.value)" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
                                    </div>
                                    <label id="emailErrorLabel123123" class="error-label" style="color: red; display: none;">Please enter a valid email address!</label>
                                </div>

                                <style>
                                    .invalid-email123123 {
                                        border-color: red;
                                    }
                                </style>

                                <script>
                                    function validateEmail(email) {
                                        var emailInput = document.getElementById('email123123');
                                        var isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

                                        if (!isValidEmail) {
                                            emailInput.classList.add('invalid-email123123');
                                            document.getElementById('emailErrorLabel123123').style.display = 'block';
                                        } else {
                                            emailInput.classList.remove('invalid-email123123');
                                            document.getElementById('emailErrorLabel123123').style.display = 'none';
                                        }
                                    }
                                </script>

                            </div>

                                <br>
                            <div class="row mx-0">
                                <h4>School Demographic</h4>
                                <div class="col-md-4">
                                <div class="form-group mb-3">
                            <label for="accessibility">Accessibility:</label>
                            <select id="accessibility" name="accessibility"  class="form-control" required>
                                <option value="">Select Accessibility</option>
                                <option value="Highly Accessible">Highly Accessible Schools – situated in urban areas, easily reachable by public transportation.</option>
                                <option value="Moderately Accessible">Moderately Accessible Schools - Found in semi-urban or rural areas with developing infrastructure, accessible by public transportation, but may require longer travel times or multiple transfers.</option>
                                <option value="Last Mile Schools">Last Mile Schools - Located in remote, rural, or mountainous areas, difficult to reach, often requiring long travel times, multiple modes of transport, or even walking.</option>
                            </select>
                            </div>
                            </div>

                                                            <div class="col-md-4">
                                                            <div class="form-group mb-3">
                            <label for="facilities">Facilities:</label>
                            <select id="facilities" name="facilities"  class="form-control" required>
                                <option value="">Select Level</option>
                                <option value="Fully Equipped">Fully Equipped School – With complete classrooms, computer laboratory, science laboratory, library, SLRC, sports and health facilities.</option>
                                <option value="Moderately Equipped">Moderately Equipped Schools – With basic functional classrooms, shared classrooms, basic laboratories, basic sports and health facilities.</option>
                                <option value="Minimally Equipped">Minimally Equipped Schools – Basic classrooms that need repairs, limited or no laboratories, limited or no health services, limited or no sports facilities.</option>
                            </select>
                            </div>
                            </div>

                                                            <div class="col-md-4">
                                                            <div class="form-group mb-3">
                            <label for="internet">Internet Connectivity:</label>
                            <select id="internet" name="internet" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="High speed internet">High speed internet (200mbps and above)</option>
                                <option value="Average speed internet">Average speed internet (below 200 mbps)</option>
                                <option value="No internet">No internet</option>
                            </select>
                            </div>
                            </div>
                            </div>
                                <br>
                                                        <div class="row mx-0">

                                <h4>School Account Details</h4>
                                <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Password <span style="color:red;">*</span></label>
                                    <input type="password" class="form-control" placeholder="Enter Password" name="password123" id="password123" required oninput="validatePassword()">
                                </div>
                            </div>
                                <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label">Confirm Password <span style="color:red;">*</span></label>
                                    <input type="password" class="form-control" placeholder="Confirm Password" name="confirmPassword123" id="confirmPassword123" required oninput="validatePassword()">
                                </div>
                            </div>
                                <center>
                                    <label id="passwordErrorLabelqwe" class="error-label" style="color: red; display: none;">Passwords must match.</label>
                                    <label id="lengthErrorLabelqwe" class="error-label" style="color: red; display: none;">Password must be at least 8 characters long.</label>
                                    <label id="uppercaseErrorLabelqwe" class="error-label" style="color: red; display: none;">Password must contain at least one uppercase letter.</label>
                                    <label id="numberErrorLabelqwe" class="error-label" style="color: red; display: none;">Password must contain at least one number.</label>
                                    <label id="symbolErrorLabelqwe" class="error-label" style="color: red; display: none;">Password must contain at least one symbol.</label>
                                </center>

                                <script>
                                    function validatePassword() {
                                        var passwordInput = document.getElementById('password123');
                                        var confirmPasswordInput = document.getElementById('confirmPassword123');

                                        var passwordErrorLabel = document.getElementById('passwordErrorLabelqwe');
                                        var lengthErrorLabel = document.getElementById('lengthErrorLabelqwe');
                                        var uppercaseErrorLabel = document.getElementById('uppercaseErrorLabelqwe');
                                        var numberErrorLabel = document.getElementById('numberErrorLabelqwe');
                                        var symbolErrorLabel = document.getElementById('symbolErrorLabelqwe');

                                        var password = passwordInput.value;
                                        var confirmPassword = confirmPasswordInput.value;

                                        var hasMatch = password === confirmPassword;
                                        var hasValidLength = password.length >= 8;
                                        var hasUppercase = /[A-Z]/.test(password);
                                        var hasNumber = /\d/.test(password);
                                        var hasSymbol = /[!@#$%^&*()]/.test(password);

                                        if (hasMatch) {
                                            passwordInput.classList.remove('invalid-password');
                                            confirmPasswordInput.classList.remove('invalid-password');
                                            passwordErrorLabel.style.display = 'none';
                                        } else {
                                            passwordInput.classList.add('invalid-password');
                                            confirmPasswordInput.classList.add('invalid-password');
                                            passwordErrorLabel.style.display = 'block';
                                        }

                                        lengthErrorLabel.style.display = hasValidLength ? 'none' : 'block';
                                        uppercaseErrorLabel.style.display = hasUppercase ? 'none' : 'block';
                                        numberErrorLabel.style.display = hasNumber ? 'none' : 'block';
                                        symbolErrorLabel.style.display = hasSymbol ? 'none' : 'block';
                                    }
                                </script>



                                <div class="d-grid">
                                    <br>
                                    <button type="submit" name="registernow" class="btn btn-primary" style="color:white;"><b>Register Account</b></button>
                                    <br>
                                </div>
                            </div>
                            <script>
                            function validateForm() {
                                var isValidPassword = validatePassword();

                                // Check if any error labels are visible
                                var errorLabels = document.querySelectorAll('.error-label');
                                for (var i = 0; i < errorLabels.length; i++) {
                                    if (errorLabels[i].style.display !== 'none') {
                                        // If any error label is still visible, prevent form submission
                                        return false;
                                    }
                                }

                                // Form submission will proceed if the password is valid and no error labels are visible
                                return isValidPassword;
                            }
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
            include('footer.php');
            
            ?>
    </body>
</html>