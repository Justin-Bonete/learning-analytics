<?php
    require_once('database_connection.php');
?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

if (isset($_POST['login'])) {
    $_SESSION['loginresult'] = '';
    $username = $_POST['username'];
    $password = md5($_POST['password']); // MD5 is outdated; consider using password_hash()

    // ✅ Check in `schools` table first
    $checkSchool = mysqli_query($DB, "SELECT * FROM schools WHERE email = '$username' AND password = '$password' AND email_status = 'Active'");

    if (mysqli_num_rows($checkSchool) > 0) {
        $schoolRecord = mysqli_fetch_assoc($checkSchool);
        $_SESSION['logged'] = 'True';
        $_SESSION['user_id'] = $schoolRecord['id'];
        $_SESSION['school_name'] = $schoolRecord['school_name'];
        $_SESSION['school_id'] = $schoolRecord['school_id'];
        $_SESSION['email'] = $schoolRecord['email'];
        $_SESSION['accessibility'] = $schoolRecord['accessibility'];
        $_SESSION['facilities'] = $schoolRecord['facilities'];
        $_SESSION['internetconnectivity'] = $schoolRecord['internetconnectivity'];
        $_SESSION['district'] = $schoolRecord['district'];
        $_SESSION['priviledges'] = 'School';
        $_SESSION['loginresult'] = '';
        header('Location: index.php');
        exit();
    }

    // ✅ If not found in `schools`, check `teachers_profiling`
    $checkTeacher = mysqli_query($DB, "SELECT * FROM teachers_profiling WHERE email = '$username' AND password = '$password'");

    if (mysqli_num_rows($checkTeacher) > 0) {
        $teacherRecord = mysqli_fetch_assoc($checkTeacher);
        $_SESSION['logged'] = 'True';
        $_SESSION['user_id'] = $teacherRecord['id'];
        $_SESSION['teacher_name'] = $teacherRecord['teacher_name'];
        $_SESSION['email'] = $teacherRecord['email'];
        $_SESSION['school_id'] = $teacherRecord['school_id'];
        $_SESSION['position'] = $teacherRecord['position'];
        $_SESSION['priviledges'] = 'Teacher';
        $_SESSION['school_name'] = $teacherRecord['teacher_name'];
        $_SESSION['grade_level'] = $teacherRecord['grade_level'];
        $_SESSION['years_exp'] = $teacherRecord['years_exp'];
        $_SESSION['major'] = $teacherRecord['major'];
        $_SESSION['education'] = $teacherRecord['education'];

        $_SESSION['no_of_trainings'] = $teacherRecord['no_of_trainings'];
        $school_id = $_SESSION['school_id'];

        $_SESSION['school_namers'] = '';
        // ✅ Check in `schools` table first
        $checkSchoolgb1 = mysqli_query($DB, "SELECT * FROM schools WHERE school_id='$school_id'");

        if (mysqli_num_rows($checkSchoolgb1) > 0) {
            $schoolRecordgb1 = mysqli_fetch_assoc($checkSchoolgb1);
            $_SESSION['district'] = $schoolRecordgb1['district'];     
            $_SESSION['school_namers'] = $schoolRecordgb1['school_name']; // Store the school name in session
        }

        $_SESSION['loginresult'] = '';
        header('Location: index.php'); // Redirect to teacher dashboard
        exit();
    }

    // ✅ If user not found in both tables, show error
    $_SESSION['loginresult'] = 'Invalid Credentials or Unverified Email Address!';
    header('Location: index.php');
    exit();
}


    if(isset($_POST['Updateprofile']))
    {
        $_SESSION['Updateprofile_result'] = '';
        $firstName = $_POST['firstName'];
        $middleName = $_POST['MI'];
        $lastName = $_POST['lastName'];
        $dateOfBirth = $_POST['dateOfBirth'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $contactNumber = $_POST['contact'];
        $passwordchecker = $_POST['password'];
        $password = md5($_POST['password']);
        $emailadd = $_SESSION['email'];

        $path = $_FILES['profileimage']['name'];
        $path_tmp = $_FILES['profileimage']['tmp_name'];

        if($passwordchecker != '')
        {
            if ($path != '') 
            {
                try 
                {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $file_name = basename($path, '.' . $ext);
                    
                    $profile_timestamp = time();
                    $profile_image = 'Profile-'.$profile_timestamp.'-'.$file_name.'-.'. $ext;
                    move_uploaded_file($path_tmp, 'assets/uploads/'.$profile_image);

                    $sql = "UPDATE users SET
                              profile_picture = '$profile_image',
                              firstName = '$firstName',
                              middleName = '$middleName',
                              lastName = '$lastName',
                              dateOfBirth = '$dateOfBirth',
                              gender = '$gender',
                              address = '$address',
                              contactNumber = '$contactNumber',
                              password = '$password'
                            WHERE email = '$emailadd'";

                    $query = mysqli_query($DB, $sql);
                } 
                catch (Exception $e) 
                {
                    // Catch any exceptions and display the error message
                    echo "Error: " . $e->getMessage();
                }
                    $_SESSION['firstName'] = $firstName;
                    $_SESSION['middleName'] = $middleName;
                    $_SESSION['lastName'] = $lastName;  
                    $_SESSION['dateOfBirth'] = $dateOfBirth;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['address'] = $address;
                    $_SESSION['contactNumber'] = $contactNumber;               
                    $_SESSION['Profile_image'] = $profile_image;
                    $_SESSION['password'] = $password;
                    

                unset($_POST['Updateprofile']);
                $_SESSION['Updateprofile_result'] = 'Your profile has been updated successfully!';
                showSweetAlertSucced("Success!", "Your profile has been updated successfully!", "success"); 
                    
            } 
            else 
            {
                try 
                {
                $sql = "UPDATE users
                        SET
                              firstName = '$firstName',
                              middleName = '$middleName',
                              lastName = '$lastName',
                              dateOfBirth = '$dateOfBirth',
                              gender = '$gender',
                              address = '$address',
                              contactNumber = '$contactNumber',
                              password = '$password'
                            WHERE email = '$emailadd'";

                $query = mysqli_query($DB, $sql);
                } 
                catch (Exception $e) 
                {
                    // Catch any exceptions and display the error message
                    echo "Error: " . $e->getMessage();
                }
              

                    $_SESSION['firstName'] = $firstName;
                    $_SESSION['middleName'] = $middleName;
                    $_SESSION['lastName'] = $lastName;  
                    $_SESSION['dateOfBirth'] = $dateOfBirth;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['address'] = $address;
                    $_SESSION['contactNumber'] = $contactNumber;  
                    $_SESSION['password'] = $password;

                unset($_POST['Updateprofile']);
                $_SESSION['Updateprofile_result'] = 'Your profile has been updated successfully!';
                showSweetAlertSucced("Success!", "Your profile has been updated successfully!", "success"); 
            }
        }
        else
        {
            if ($path != '') 
            {
                try 
                {
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    $file_name = basename($path, '.' . $ext);
                    
                    $profile_timestamp = time();
                    $profile_image = 'Profile-'.$profile_timestamp.'-'.$file_name.'-.'. $ext;
                    move_uploaded_file($path_tmp, 'assets/uploads/'.$profile_image);

                    $sql = "UPDATE users SET
                              profile_picture = '$profile_image',
                              firstName = '$firstName',
                              middleName = '$middleName',
                              lastName = '$lastName',
                              dateOfBirth = '$dateOfBirth',
                              gender = '$gender',
                              address = '$address',
                              contactNumber = '$contactNumber'
                            WHERE email = '$emailadd'";

                    $query = mysqli_query($DB, $sql);
                } 
                catch (Exception $e) 
                {
                    // Catch any exceptions and display the error message
                    echo "Error: " . $e->getMessage();
                }
                    $_SESSION['firstName'] = $firstName;
                    $_SESSION['middleName'] = $middleName;
                    $_SESSION['lastName'] = $lastName;  
                    $_SESSION['dateOfBirth'] = $dateOfBirth;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['address'] = $address;
                    $_SESSION['contactNumber'] = $contactNumber;               
                    $_SESSION['Profile_image'] = $profile_image;
                    

                unset($_POST['Updateprofile']);
                $_SESSION['Updateprofile_result'] = 'Your profile has been updated successfully!';
                showSweetAlertSucced("Success!", "Your profile has been updated successfully!", "success"); 
            } 
            else 
            {
                try 
                {
                $sql = "UPDATE users SET 
                              firstName = '$firstName',
                              middleName = '$middleName',
                              lastName = '$lastName',
                              dateOfBirth = '$dateOfBirth',
                              gender = '$gender',
                              address = '$address',
                              contactNumber = '$contactNumber'
                            WHERE email = '$emailadd'";

                $query = mysqli_query($DB, $sql);
               
                } 
                catch (Exception $e) 
                {
                    // Catch any exceptions and display the error message
                    echo "Error: " . $e->getMessage();
                }

                    $_SESSION['firstName'] = $firstName;
                    $_SESSION['middleName'] = $middleName;
                    $_SESSION['lastName'] = $lastName;  
                    $_SESSION['dateOfBirth'] = $dateOfBirth;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['address'] = $address;
                    $_SESSION['contactNumber'] = $contactNumber;  

                unset($_POST['Updateprofile']);
                $_SESSION['Updateprofile_result'] = 'Your profile has been updated successfully!';
                showSweetAlertSucced("Success!", "Your profile has been updated successfully!", "success"); 
            }
        }
    }


    function showSweetAlertSucced($title, $message, $type) {
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
    function showSweetAlertFailed($title, $message, $type) {
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
<!-- Modal -->
    <?php if(isset($_SESSION['loginresult']) && $_SESSION['loginresult'] != '') { ?>
        <div class="modal fade auto-open-modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <?php }else{ ?>
        <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <?php } ?>
    <div class="modal-dialog about-login-dialog">
        <div class="modal-content about-login-card">
            <div class="modal-header">
                <div class="about-login-heading">
                    <span class="about-login-brand"><img src="images/abra-gov-seal.png" alt=""></span>
                    <span>
                        <small>ABRA LEARNING ANALYTICS</small>
                        <h5 class="modal-title" id="loginModalLabel">Welcome back</h5>
                    </span>
                </div>
                <button type="button" class="btn-close about-login-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?php if(isset($_SESSION['loginresult']) && $_SESSION['loginresult'] != '') { ?>
                <div class="about-login-error" role="alert">
                    <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                    <?php echo htmlspecialchars($_SESSION['loginresult'], ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php } ?>

            <div class="modal-body">
                    <p class="about-login-intro">Sign in with your school or teacher account to continue to your workspace.</p>
                    <form action="" method="POST" class="about-login-form">
                        <div class="about-login-field">
                            <label for="username">Email address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="far fa-envelope" aria-hidden="true"></i></span>
                                <input type="email" class="form-control" id="username" name="username" placeholder="name@school.edu.ph" autocomplete="username" required>
                            </div>
                        </div>
                        <div class="about-login-field">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock" aria-hidden="true"></i></span>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required>
                            </div>
                        </div>
                        <div class="d-grid about-login-submit">
                            <button name="login" class="btn" type="submit">
                                Sign in <i class="fas fa-arrow-right" aria-hidden="true"></i>
                            </button>
                        </div>

                        <div class="about-login-help">
                            <i class="far fa-life-ring" aria-hidden="true"></i>
                            <span>Need help accessing your account? <a href="contact_guest.php">Contact us</a></span>
                        </div>
                    </form>
                    <div class="about-login-divider"><span>OR</span></div>
                    <a href="adminLogin.php" class="about-supervisor-link">
                        <i class="fas fa-user-shield" aria-hidden="true"></i>
                        <span><strong>Supervisor sign in</strong><small>For authorized division administrators</small></span>
                        <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>

            </div>
        </div>
    </div>
</div>

    <?php if(isset($_SESSION['loginresult']) && $_SESSION['loginresult'] != '') { ?>
        <script>
          // Wait for the page to load
          document.addEventListener("DOMContentLoaded", function() {
            // Get the modal element
            var modal = document.querySelector(".auto-open-modal");

            // Open the modal using Bootstrap's JavaScript API
            var modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
          });
        </script>
    <?php $_SESSION['loginresult']='';} ?>


    <?php if(isset($_SESSION['Updateprofile_result']) && $_SESSION['Updateprofile_result'] != '') { ?>
    <div class="modal fade auto-open-modal2" id="editProfile">
    <?php }else{ ?>
    <div class="modal fade" id="editProfile">
    <?php } ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Profile</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?php if(isset($_SESSION['Updateprofile_result']) && $_SESSION['Updateprofile_result'] != '') { ?>
            <br>
                <center><b><span style="color:red;"><?php echo $_SESSION['Updateprofile_result']; ?></span></b><center>
            <?php } ?>
            <div class="modal-body">
            <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validateForm_UserEditProf1()">
                <div class="row accent-blue">         
                    <div class="col-12 col-md-12 col-lg-12 mb-3" style="margin-top:1vh;">
                        <label for="ProfilePricture">Change Profile Pricture </label>
                        <div class="form-group">
                            <input type="file" class="form-control" id="profileimage" name="profileimage">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="firstName">First Name </label>
                            <input type="text" name="firstName" id="firstName" class="form-control" value="<?php echo htmlspecialchars($_SESSION['firstName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="MI">Middle Name/Initials </label>
                            <input type="text" name="MI" id="MI" class="form-control" value="<?php echo htmlspecialchars($_SESSION['middleName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="lastName">Last Name </label>
                            <input type="text" name="lastName" id="lastName" class="form-control" value="<?php echo htmlspecialchars($_SESSION['lastName'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-6" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="dateOfbirth">Date Of Birth </label>
                            <input type="date" name="dateOfBirth" id="dateOfBirth" class="form-control" value="<?php echo htmlspecialchars($_SESSION['dateOfBirth'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>
                                <script>
                                    // Get the date input field
                                    var dobInput = document.getElementById('dateOfBirth');

                                    // Calculate the minimum allowed date
                                    var today = new Date();
                                    var minDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate());

                                    // Format the minimum date as YYYY-MM-DD
                                    var minDateFormatted = minDate.toISOString().split('T')[0];

                                    // Set the minimum date attribute of the input field
                                    dobInput.setAttribute('max', minDateFormatted);

                                    // Add event listener for date change
                                    dobInput.addEventListener('input', function () {
                                        var selectedDate = new Date(this.value);
                                        if (selectedDate > minDate) {
                                            this.setCustomValidity('You must be 18 years old or above.');
                                        } else {
                                            this.setCustomValidity('');
                                        }
                                    });
                                </script>


                    <div class="col-12 col-md-6 col-lg-6" style="margin-top:1vh;">
                        <label for="gender">Gender </label>
                        <div class="form-group">

                            <div class="form-check-inline py-1">
                                <?php if(($_SESSION['gender'] ?? '') == 'Male') { ?>
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="Male"
                                        name="gender" checked>
                                <?php }else{ ?>
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="Male"
                                        name="gender">
                                <?php } ?>
                                <label class="form-check-label" for="male">                               
                                    Male
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <?php if(($_SESSION['gender'] ?? '') == 'Female') { ?>
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female"
                                    name="gender" checked>
                                 <?php }else{ ?>
                                <input class="form-check-input" type="radio" name="gender" id="female" value="Female"
                                    name="gender">
                                <?php } ?>
                                <label class="form-check-label" for="female">
                                    Female
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="contact">Contact Number </label>
                            <input type="number" name="contact" id="contact" class="form-control" placeholder="9xxxxxxxxx" oninput="validateContactNumber(this)" value="<?php echo htmlspecialchars($_SESSION['contactNumber'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                            <label id="contactErrorLabel" class="error-label-UserEditProf1" style="color: red; display: none;">Contact number should start with "9"! Example: 9xxxxxxxxx</label>
                    </div>


                                <script>
                                    function validateContactNumber(input) {
                                        var inputValue = input.value;

                                        // Remove any non-numeric characters
                                        var numericValue = inputValue.replace(/\D/g, '');

                                        // Ensure the number starts with '+639' and has a length of 13 characters
                                        if (!numericValue.startsWith('9') || numericValue.length !== 10) {
                                            document.getElementById('contactErrorLabel').style.display = 'block';
                                        } else {
                                            // Format the number as '+639XXXXXXXXX'
                                            var formattedValue = numericValue;
                                            input.value = formattedValue;
                                            document.getElementById('contactErrorLabel').style.display = 'none';
                                        }
                                    }
                                </script>

                    <div class="col-12 col-md-12 col-lg-12" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="address">Address </label>
                            <input type="text" name="address" id="address" class="form-control" value="<?php echo htmlspecialchars($_SESSION['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlspecialchars($_SESSION['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" disabled>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="password">Change Password </label>
                            <input type="password" name="password" id="passwordaa" class="form-control" value="" oninput="validatePassword()">
                        </div>

                                <center>
                                    <label id="lengthErrorLabel" class="error-label-UserEditProf1" style="color: red; display: none;">Password must be at least 8 characters long.</label>
                                    <label id="uppercaseErrorLabel" class="error-label-UserEditProf1" style="color: red; display: none;">Password must contain at least one uppercase letter.</label>
                                    <label id="numberErrorLabel" class="error-label-UserEditProf1" style="color: red; display: none;">Password must contain at least one number.</label>
                                    <label id="symbolErrorLabel" class="error-label-UserEditProf1" style="color: red; display: none;">Password must contain at least one symbol.</label>
                                </center>
                                <script>
                                    function validatePassword() {
                                        var passwordInput = document.getElementById('passwordaa');

                                        var lengthErrorLabel = document.getElementById('lengthErrorLabel');
                                        var uppercaseErrorLabel = document.getElementById('uppercaseErrorLabel');
                                        var numberErrorLabel = document.getElementById('numberErrorLabel');
                                        var symbolErrorLabel = document.getElementById('symbolErrorLabel');

                                        var password = passwordInput.value;
                                        var hasValidLength = password.length >= 8;
                                        var hasUppercase = /[A-Z]/.test(password);
                                        var hasNumber = /\d/.test(password);
                                        var hasSymbol = /[!@#$%^&*()]/.test(password);

                                        if (password === "") {
                                            lengthErrorLabel.style.display = 'none';
                                            uppercaseErrorLabel.style.display = 'none';
                                            numberErrorLabel.style.display = 'none';
                                            symbolErrorLabel.style.display = 'none';
                                        } else {
                                            lengthErrorLabel.style.display = hasValidLength ? 'none' : 'block';
                                            uppercaseErrorLabel.style.display = hasUppercase ? 'none' : 'block';
                                            numberErrorLabel.style.display = hasNumber ? 'none' : 'block';
                                            symbolErrorLabel.style.display = hasSymbol ? 'none' : 'block';
                                        }
                                    }
                                </script>

                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-end">
                <button name="Updateprofile" id="Updateprofile" class="btn btn-md btn-secondary btn-orange" type="submit" >Update Profile</button>
            </div>

            <script>
            function validateForm_UserEditProf1() {
                // Check if any error labels are visible
                var errorLabels_UserEditProf1 = document.querySelectorAll('.error-label-UserEditProf1');
                for (var i = 0; i < errorLabels_UserEditProf1.length; i++) {
                    if (errorLabels_UserEditProf1[i].style.display !== 'none') {
                    // If any error label is still visible, prevent form submission
                    return false;
                    }
                }
            }
            </script>
            </form>

        </div>

        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


    <?php if(isset($_SESSION['Updateprofile_result']) && $_SESSION['Updateprofile_result'] != '') { ?>
        <script>
          // Wait for the page to load
          document.addEventListener("DOMContentLoaded", function() {
            // Get the modal element
            var modal = document.querySelector(".auto-open-modal2");

            // Open the modal using Bootstrap's JavaScript API
            var modalInstance = new bootstrap.Modal(modal);
            modalInstance.show();
          });
        </script>
    <?php $_SESSION['Updateprofile_result']='';} ?>