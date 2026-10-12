

<?php
 if(isset($_POST['updateprofileinfo']))
{
        $validation = 1;
        $userID = $_SESSION['user_id'];
        $checkpass = $_POST['passwordgbbb1']; // password
        $password = md5($_POST['passwordgbbb1']);
        $fullanme = $firstName.' '.$middleName.' '.$lastName;
        
        
                        $teacher_name = $_POST['teacher_name'];
                        $years_exp = $_POST['years_exp']; // Ensure it's an integer
                        $position = $_POST['position'];
                        $grade_level =  $_POST['grade_level'];
                        $major = $_POST['major'];
                        $education =$_POST['education'];
                        $no_of_trainings = $_POST['no_of_trainings']; // Ensure it's an integer
                        
        if($validation == 1)
        {
            if($checkpass == '')
            {   
                    
                        $updateQuery = "UPDATE teachers_profiling SET 
                            teacher_name = '$teacher_name', 
                            years_exp = '$years_exp', 
                            position = '$position', 
                            grade_level = '$grade_level', 
                            major = '$major', 
                            education = '$education', 
                            no_of_trainings = '$no_of_trainings' 
                            WHERE id = '$userID'";
                    
                        if (mysqli_query($DB, $updateQuery)) {
                            showSweetAlertSucced("Success!", "Profile updated successfully.", "success");
                        } else {
                            $error = "Error: " . mysqli_error($DB);
                            showSweetAlertFailed("Failed!", $error, "error");
                        }
                    

                
            }
            else
            {
                
                    
                        $updateQuery = "UPDATE teachers_profiling SET 
                            teacher_name = '$teacher_name', 
                            years_exp = '$years_exp', 
                            position = '$position', 
                            grade_level = '$grade_level', 
                            major = '$major', 
                            education = '$education', 
                            no_of_trainings = '$no_of_trainings', 
                            password = '$password'
                            WHERE id = '$userID'";
                    
                        if (mysqli_query($DB, $updateQuery)) {
                            showSweetAlertSucced("Success!", "Profile & Password updated successfully.", "success");
                        } else {
                            $error = "Error: " . mysqli_error($DB);
                            showSweetAlertFailed("Failed!", $error, "error");
                        }
                    
                
            }
            
            
                $checkTeacher = mysqli_query($DB, "SELECT * FROM teachers_profiling WHERE id = '$userID'");
            
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
            <form action="" method="post" enctype="multipart/form-data"  onsubmit="return validateFormEditMyProfile()">
                <div class="modal-header">
                    <h4 class="modal-title">Edit My Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row accent-blue">

                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="firstName">Name </label>
                                <input type="text" name="teacher_name" id="teacher_name" class="form-control" value="<?php echo $_SESSION['teacher_name']; ?>">
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="form-group">
                                <label for="email">Email address </label>
                                <input type="text" name="email" id="email" class="form-control"  value="<?php echo $_SESSION['email']; ?>"
                                    disabled>
                            </div>
                        </div>
                        
                    <div class="form-group col-md-6">
                        <label for="years_exp">Years of Experience</label>
                        <input type="number" name="years_exp" class="form-control"  value="<?php echo $_SESSION['years_exp']; ?>"  required>
                    </div>



                                                <div class="form-group col-md-6">
                                                    <label for="position">Position</label><select name="position" class="form-control" required>
    <?php
    $positions = [
        "Teacher I", "Teacher II", "Teacher III", "Teacher IV", "Teacher V", "Teacher VI", "Teacher VII",
        "Master Teacher I", "Master Teacher II", "Master Teacher III", "Master Teacher IV", "Master Teacher V"
    ];
    foreach ($positions as $pos) {
        $selected = ($_SESSION['position'] === $pos) ? 'selected' : '';
        echo "<option value=\"$pos\" $selected>$pos</option>";
    }
    ?>
</select>

                                                </div>
<div class="form-group col-md-6">
    <label for="grade_level">Grade Level</label>
    <select name="grade_level" class="form-control">
        <?php 
        for ($i = 1; $i <= 12; $i++) {
            $selected = ($row['grade_level'] == "Grade $i") ? 'selected' : '';
            echo "<option value='Grade $i' $selected>Grade $i</option>";
        }
        ?>
        <option value="Kinder" <?php if($_SESSION['grade_level'] == 'Kinder'){ echo 'selected'; } ?>>Kinder</option>
    </select>
</div>
                    <div class="form-group  col-md-6">
                        <label for="major">Major/Specailization</label>
                        <input type="text" name="major" class="form-control" value="<?php echo $_SESSION['major']; ?>"  required>
                    </div>
<div class="form-group col-md-6">
    <label for="education">Education</label>
    <select name="education" class="form-control">
        <option value="Bachelor" <?php if ($row['education'] == 'Bachelor') echo 'selected'; ?>>Bachelor</option>
        <option value="Master" <?php if ($row['education'] == 'Master') echo 'selected'; ?>>Master</option>
        <option value="Doctor" <?php if ($row['education'] == 'Doctor') echo 'selected'; ?>>Doctor</option>
    </select>
</div>


                    <div class="form-group col-md-6">
                        <label for="no_of_trainings">Number of Trainings</label>
                        <input type="number" name="no_of_trainings" class="form-control"  value="<?php echo $_SESSION['no_of_trainings']; ?>"  required>
                    </div>
                    <hr>
                        
                        <div class="col-12 col-md-12 col-lg-12" style="display:none;">
                            <div class="form-group">
                                <label for="password">Change Password </label>
                                <input type="password" name="passwordgbbb1" id="passwordgbbb1" class="form-control" value="" oninput="validatePassword()">
                            </div>
                                <center>
                                    <label id="lengthErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must be at least 8 characters long.</label>
                                    <label id="uppercaseErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must contain at least one uppercase letter.</label>
                                    <label id="numberErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must contain at least one number.</label>
                                    <label id="symbolErrorLabel" class="error-labelEditMyProfile" style="color: red; display: none;">Password must contain at least one symbol.</label>
                                </center>
                                <script>
                                    function validatePassword() {
                                        var passwordInput = document.getElementById('passwordgbbb1');

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
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
