<?php
    require_once('database_connection.php');
?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<?php

    if(isset($_POST['login']))
    {
        $_SESSION['loginresult'] = '';
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $tenantcode = $_POST['tenantcode'];
        $checkresident = mysqli_query($DB, "SELECT * FROM users WHERE email = '$username' AND password = '$password' and tenant_code = '$tenantcode' AND tenant_code <> '0' AND unit_number <> '0'");
        if (mysqli_num_rows($checkresident) > 0) 
        {
            while ($residentrecord = mysqli_fetch_assoc($checkresident)) 
            {
                $_SESSION['logged'] = 'True'; //if false it means log out;
                $_SESSION['user_id'] = $residentrecord['user_id'];
                $_SESSION['firstName'] = $residentrecord['firstName'];
                $_SESSION['middleName'] = $residentrecord['middleName'];
                $_SESSION['lastName'] = $residentrecord['lastName'];
                $_SESSION['fullname'] = $_SESSION['firstName'].' '.$_SESSION['middleName'].'. '.$_SESSION['lastName'];
                $_SESSION['dateOfBirth'] = $residentrecord['dateOfBirth'];
                $_SESSION['gender'] = $residentrecord['gender'];
                $_SESSION['address'] = $residentrecord['address'];
                $_SESSION['contactNumber'] = $residentrecord['contactNumber'];
                $_SESSION['email'] = $residentrecord['email'];
                $_SESSION['password'] = $residentrecord['password'];
                $_SESSION['Activation_code'] = $residentrecord['Activation_code'];    
                $_SESSION['Profile_image'] = $residentrecord['profile_picture'];          
            }
            
            $_SESSION['loginresult'] = '';
            unset($_POST['login']);
            header('Location: index.php');
            exit();
        }
        else
        {
            unset($_POST['login']);
            $_SESSION['loginresult'] = 'Invalid Credentials!';
            header('Location: index.php');
            exit();
        }
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?php if(isset($_SESSION['loginresult']) && $_SESSION['loginresult'] != '') { ?>
            <br>
                <center><b><span style="color:red;"><?php echo $_SESSION['loginresult']; ?></span></b><center>
            <?php } ?>

            <div class="modal-body">
                    <form action="" method="POST">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="email" class="form-control" id="username" name="username" placeholder="Email">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="text" class="form-control" id="tenantcode" name="tenantcode" placeholder="Tenant Code">
                        </div>
                        <br>
                        <div class="d-grid gap-2 mb-3">
                            <button name="login" class="btn btn-md btn-primary" type="submit">Login</button>
                        </div>

                        <div class="text-center">
                            <small>Do you want to message us first? <a href="contact_guest.php">Contact Us!</a></small>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <a href="register.php" class="btn btn-secondary btn-white">Create an
                            account</a>
                    </div>
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
                            <input type="text" name="firstName" id="firstName" class="form-control"  value="<?php echo$_SESSION['firstName']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="MI">Middle Name/Initials </label>
                            <input type="text" name="MI" id="MI" class="form-control"  value="<?php echo$_SESSION['middleName']; ?>">
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-12" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="lastName">Last Name </label>
                            <input type="text" name="lastName" id="lastName" class="form-control" value="<?php echo$_SESSION['lastName']; ?>">
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-6" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="dateOfbirth">Date Of Birth </label>
                            <input type="date" name="dateOfBirth" id="dateOfBirth" class="form-control" value="<?php echo$_SESSION['dateOfBirth']; ?>">
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
                                <?php if($_SESSION['gender'] == 'Male') { ?>
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
                                <?php if($_SESSION['gender'] == 'Female') { ?>
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
                            <input type="number" name="contact" id="contact" class="form-control" placeholder="9xxxxxxxxx" oninput="validateContactNumber(this)" value="<?php echo$_SESSION['contactNumber']; ?>">
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
                            <input type="text" name="address" id="address" class="form-control" value="<?php echo$_SESSION['address']; ?>">
                        </div>
                    </div>

                    <div class="col-12 col-md-12 col-lg-12" style="margin-top:1vh;">
                        <div class="form-group">
                            <label for="email">Email </label>
                            <input type="email" name="email" id="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" disabled>
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