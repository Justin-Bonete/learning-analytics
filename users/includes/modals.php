<?php
if(isset($_POST['updateprofileinfo']))
{
    $validation = 1;
    $userID = $_SESSION['user_id'];
    $checkpass = $_POST['password']; // password
    $password = md5($_POST['password']);
    $school_name = $_POST['school_name'];
    $school_id = $_POST['school_id'];
    $accessibility = $_POST['accessibility'];
    $facilities = $_POST['facilities'];
    $internet = $_POST['internet'];
    $district = $_POST['district'];
    
    if($validation == 1)
    {
        if($checkpass != '')
        {   
            $query = "UPDATE schools SET 
                    school_name = '$school_name',
                    school_id = '$school_id',
                    password = '$password',
                    accessibility = '$accessibility',
                    facilities = '$facilities',
                    internetconnectivity = '$internet',
                    district = '$district'
                    WHERE 
                    id = $userID";
            $result = mysqli_query($DB, $query);

            if ($result) {
                $_SESSION['school_name'] = $school_name;
                $_SESSION['school_id'] = $school_id;
                $_SESSION['password'] = $password;
                $_SESSION['accessibility'] = $accessibility;
                $_SESSION['facilities'] = $facilities;
                $_SESSION['internetconnectivity'] = $internet;
                $_SESSION['district'] = $district;
                unset($_POST['updateprofileinfo']);
                showSweetAlertSucced("Success!", "Your profile has been updated successfully.", "success");  
            } else {
                $error = "Error updating profile: " . mysqli_error($DB);
                unset($_POST['updateprofileinfo']);
                showSweetAlertFailed("Failed!", $error, "error");
            }
        } else {
            $query = "UPDATE schools SET 
                    school_name = '$school_name',
                    school_id = '$school_id',
                    accessibility = '$accessibility',
                    facilities = '$facilities',
                    internetconnectivity = '$internet',
                    district = '$district'
                    WHERE 
                    id = $userID";
            $result = mysqli_query($DB, $query);

            if ($result) {
                $_SESSION['school_name'] = $school_name;
                $_SESSION['school_id'] = $school_id;
                $_SESSION['accessibility'] = $accessibility;
                $_SESSION['facilities'] = $facilities;
                $_SESSION['internetconnectivity'] = $internet;
                $_SESSION['district'] = $district;
                unset($_POST['updateprofileinfo']);
                showSweetAlertSucced("Success!", "Your profile has been updated successfully.", "success");  
            } else {
                $error = "Error updating profile: " . mysqli_error($DB);
                unset($_POST['updateprofileinfo']);
                showSweetAlertFailed("Failed!", $error, "error");
            }
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
          window.location.href = 'dashboard.php';
        });
    }, 1000); // Delay in milliseconds (e.g., 1000ms = 1 second)
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
          window.location.href = 'dashboard.php';
        });
    }, 1000); // Delay in milliseconds (e.g., 1000ms = 1 second)
    </script>";
}
?>

<div class="modal fade" id="editProfile">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateFormEditMyProfile()">
                <div class="modal-header">
                    <h4 class="modal-title">Edit My Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row accent-blue">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="school_name">School Name</label>
                                <input type="text" name="school_name" id="school_name" class="form-control" value="<?php echo $_SESSION['school_name']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="school_id">School ID</label>
                                <input type="text" name="school_id" id="school_id" class="form-control" value="<?php echo $_SESSION['school_id']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-12">
                            <div class="form-group">
                                <label for="email">School Email</label>
                                <input type="text" name="email" id="email" class="form-control" value="<?php echo $_SESSION['email']; ?>" disabled>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="district">District</label>
                                <select class="form-control" id="district" name="district" required>
                                    <option value="">Select District</option>
                                    <?php
                                    $districts = ["Bangued", "Bucay", "La Paz", "Lagangilang", "Luba", "Dolores", "Pidigan", "San Juan", "Pilar", "Sallapadan"];
                                    foreach ($districts as $district) {
                                        $selected = ($_SESSION['district'] == $district) ? 'selected' : '';
                                        echo "<option value='$district' $selected>$district</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="accessibility">Accessibility</label>
                                <select class="form-control" id="accessibility" name="accessibility" required>
                                    <option value="">Select Accessibility</option>
                                    <option value="Highly Accessible" <?php echo ($_SESSION['accessibility'] == 'Highly Accessible') ? 'selected' : ''; ?>>Highly Accessible</option>
                                    <option value="Moderately Accessible" <?php echo ($_SESSION['accessibility'] == 'Moderately Accessible') ? 'selected' : ''; ?>>Moderately Accessible</option>
                                    <option value="Last Mile Schools" <?php echo ($_SESSION['accessibility'] == 'Last Mile Schools') ? 'selected' : ''; ?>>Last Mile Schools</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="facilities">Facilities</label>
                                <select class="form-control" id="facilities" name="facilities" required>
                                    <option value="">Select Level</option>
                                    <option value="Fully Equipped" <?php echo ($_SESSION['facilities'] == 'Fully Equipped') ? 'selected' : ''; ?>>Fully Equipped</option>
                                    <option value="Moderately Equipped" <?php echo ($_SESSION['facilities'] == 'Moderately Equipped') ? 'selected' : ''; ?>>Moderately Equipped</option>
                                    <option value="Minimally Equipped" <?php echo ($_SESSION['facilities'] == 'Minimally Equipped') ? 'selected' : ''; ?>>Minimally Equipped</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="internet">Internet Connectivity</label>
                                <select class="form-control" id="internet" name="internet" required>
                                    <option value="">Select Type</option>
                                    <option value="High speed internet" <?php echo ($_SESSION['internetconnectivity'] == 'High speed internet' || $_SESSION['internetconnectivity'] == 'High Speed') ? 'selected' : ''; ?>>High speed internet</option>
                                    <option value="Average speed internet" <?php echo ($_SESSION['internetconnectivity'] == 'Average speed internet' || $_SESSION['internetconnectivity'] == 'Average Speed') ? 'selected' : ''; ?>>Average speed internet</option>
                                    <option value="No internet" <?php echo ($_SESSION['internetconnectivity'] == 'No internet') ? 'selected' : ''; ?>>No internet</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-12" style="display:none;">
                            <div class="form-group">
                                <label for="password">Change Password</label>
                                <input type="password" name="password" id="password" class="form-control" oninput="validatePassword()">
                            </div>
                            <center>
                                <label id="lengthErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must be at least 8 characters long.</label>
                                <label id="uppercaseErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must contain at least one uppercase letter.</label>
                                <label id="numberErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must contain at least one number.</label>
                                <label id="symbolErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must contain at least one symbol.</label>
                            </center>
                            <script>
                                function validatePassword() {
                                    var passwordInput = document.getElementById('password');
                                    var lengthErrorLabel = document.getElementById('lengthErrorLabel');
                                    var uppercaseErrorLabel = document.getElementById('uppercaseErrorLabel');
                                    var numberErrorLabel = document.getElementById('numberErrorLabel');
                                    var symbolErrorLabel = document.getElementById('symbolErrorLabel');
                                    var password = passwordInput.value;
                                    var hasValidLength = password.length >= 8;
                                    var hasUppercase = /[A-Z]/.test(password);
                                    var hasNumber = /\d/.test(password);
                                    var hasSymbol = /[!@#$%^&*()]/.test(password);
                                    lengthErrorLabel.style.display = hasValidLength ? 'none' : 'block';
                                    uppercaseErrorLabel.style.display = hasUppercase ? 'none' : 'block';
                                    numberErrorLabel.style.display = hasNumber ? 'none' : 'block';
                                    symbolErrorLabel.style.display = hasSymbol ? 'none' : 'block';
                                }
                            </script>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-success" name="updateprofileinfo" id="updateprofileinfo">Update <i class="fas fa-edit"></i></button>
                </div>

                <script>
                function validateFormEditMyProfile() {
                    // Check if any error labels are visible
                    var errorLabelsEditMyProfile = document.querySelectorAll('.error-labelEditMyProfile');
                    for (var i = 0; i < errorLabelsEditMyProfile.length; i++) {
                        if (errorLabelsEditMyProfile[i].style.display !== 'none') {
                            // If any error label is still visible, prevent form submission
                            return false;
                        }
                    }
                }
                </script>
            </form>
        </div>
    </div>
</div>