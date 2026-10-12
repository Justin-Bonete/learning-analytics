<?php
include('includes/header.php');


    $school_id = $_SESSION['school_id'];
    $school_email =  $_SESSION['email'];

if(isset($_POST['deleteuser'])) {
    $USER_IDS = $_POST['user_ID_Delete'];
    $query = "DELETE FROM students WHERE id = '$USER_IDS'";
    $result = mysqli_query($DB, $query);

    if ($result) {    
        unset($_POST['user_ID_Delete']);  
        unset($_POST['deleteuser']);         
        showSweetAlertSucced2("Success!", "Student has been deleted successfully.", "success");  
    } else {
        unset($_POST['user_ID_Delete']); 
        unset($_POST['deleteuser']);  
        $error = "Error deleting student: " . mysqli_error($DB);
        showSweetAlertFailed2("Failed!", $error, "error");
    }
}

if (isset($_POST['updateprofileinfo'])) {
    $validation = 1;
    $userID = $_POST['user_id'];
    $student_name = $_POST['student_name'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $quarter = $_POST['quarter'];
    $grade_level = $_POST['grade_level'];
    $quarterly_attendance = $_POST['quarterly_attendance'];
    $extra_curricular = $_POST['extra_curricular'];
    $economic_status = $_POST['economic_status'];
    $settlement = $_POST['settlement'];
    $physical_mental_status = $_POST['physical_mental_status'];
    $feeding_prog_receipt = $_POST['feeding_prog_receipt'];
    $status = $_POST['status'];

    if ($validation == 1) {
        $query = "UPDATE students SET 
                    student_name = '$student_name',
                    age = '$age',
                    sex = '$sex',
                    quarter = '$quarter',
                    grade_level = '$grade_level',
                    quarterly_attendance = '$quarterly_attendance',
                    extra_curricular = '$extra_curricular',
                    economic_status = '$economic_status',
                    settlement = '$settlement',
                    physical_mental_status = '$physical_mental_status',
                    feeding_prog_receipt = '$feeding_prog_receipt',
                    status = '$status'
                  WHERE id = $userID";

        $result = mysqli_query($DB, $query);

        if ($result) {             
            unset($_POST['updateprofileinfo']);
            showSweetAlertSucced2("Success!", "Student profile has been updated successfully.", "success");  
        } else {
            $error = "Error updating profile: " . mysqli_error($DB);
            unset($_POST['updateprofileinfo']);
            showSweetAlertFailed2("Failed!", $error, "error");
        }
    }
}

if (isset($_POST['addStudent']) && !in_array((string)($_POST['quarteradd'] ?? ''), ['1', '2', '3'], true)) {
    showSweetAlertFailed2('Invalid term', 'Only Terms 1, 2, and 3 are accepted for new records.', 'error');
    exit;
}
if (isset($_POST['addStudent'])) {
    $student_name = mysqli_real_escape_string($DB, $_POST['student_nameadd']);
    $age = (int)$_POST['ageadd'];
    $sex = mysqli_real_escape_string($DB, $_POST['sexadd']);
    $quarter = mysqli_real_escape_string($DB, $_POST['quarteradd']);
    $grade_level = mysqli_real_escape_string($DB, $_POST['grade_leveladd']);
    $quarterly_attendance =  mysqli_real_escape_string($DB, $_POST['quarterly_attendanceadd']);
    $extra_curricular = mysqli_real_escape_string($DB, $_POST['extra_curricularadd']);
    $economic_status = mysqli_real_escape_string($DB, $_POST['economic_statusadd']);
    $settlement = mysqli_real_escape_string($DB, $_POST['settlementadd']);
    $physical_mental_status = mysqli_real_escape_string($DB, $_POST['physical_mental_statusadd']);
    $feeding_prog_receipt = mysqli_real_escape_string($DB, $_POST['feeding_prog_receiptadd']);
    $status = mysqli_real_escape_string($DB, $_POST['statusadd']);

    $insertQuery = "INSERT INTO students 
        (school_id, student_name, age, sex, quarter, grade_level, quarterly_attendance, 
         extra_curricular, economic_status, settlement, physical_mental_status, feeding_prog_receipt, status, created_by) 
        VALUES 
        ('$school_id', '$student_name', '$age', '$sex', '$quarter', '$grade_level', '$quarterly_attendance',
         '$extra_curricular', '$economic_status', '$settlement', '$physical_mental_status', '$feeding_prog_receipt', '$status', '$school_email')";

    if (mysqli_query($DB, $insertQuery)) {
        showSweetAlertSucced2("Success!", "New student added successfully.", "success");
    } else {
        $error = "Error: " . mysqli_error($DB);
        showSweetAlertFailed2("Failed!", $error, "error");
    }
}
     function showSweetAlertSucced2($title, $message, $type) {
            echo "
            <script>
            setTimeout(function() {
                Swal.fire({
                    title: '$title',
                    text: '$message',
                    icon: '$type',
                    confirmButtonText: 'OK'
                }).then(function() {
                  window.location.href = 'manage_student.php';
                });
            }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
            </script>";
    }
    function showSweetAlertFailed2($title, $message, $type) {
                echo "
                <script>
                setTimeout(function() {
                    Swal.fire({
                        title: '$title',
                        text: '$message',
                        icon: '$type',
                        confirmButtonText: 'OK'
                    }).then(function() {
                      window.location.href = 'manage_student.php';
                    });
                }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
                </script>";
    }

    
include('includes/topbar.php');
include('includes/sidebar.php');
include('includes/modals.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper accent-blue">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Learners</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 accent-blue">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Manage Learners</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addStudentModal">
                        Add Learners <i class="fas fa-plus"></i>
                    </button>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Term</th>
                                <th>Grade Level</th>
                                <th>Attendance</th>
                                <th>Extra Curricular</th>
                                <th>Economic Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ig1 = 0;// Check if grade_level_global is set to "All Levels"

                            // Construct grade condition correctly
                            $grade_condition = ($grade_level_global === "All Levels") ? "" : "AND grade_level = '$grade_level_global'";

                            // Construct the query dynamically
                            $query = "SELECT * FROM students WHERE school_id = '$school_id' ";

                            if (!empty($grade_condition)) {
                                $query .= " $grade_condition";
                            }

                            // Always include grade level condition
                            $query .= " AND grade_level LIKE '%Grade%' AND semester = 'None'";

                            // Execute the query
                            $studentQuery = mysqli_query($DB, $query);

                            if (mysqli_num_rows($studentQuery) > 0) {
                                while ($row = mysqli_fetch_assoc($studentQuery)) {
                                    $ig1++;
                                    $user_ID = $row['id'];
                            ?>
                                    <tr>
                                        <td><?php echo $ig1; ?></td>
                                        <td><?php echo $row['student_name']; ?></td>
                                        <td><?php echo $row['age']; ?></td>
                                        <td><?php echo $row['sex']; ?></td>
                                        <td><?php echo $row['quarter']; ?></td>
                                        <td><?php echo $row['grade_level']; ?></td>
                                        <td><?php echo $row['quarterly_attendance']; ?></td>
                                        <td><?php echo $row['extra_curricular']; ?></td>
                                        <td><?php echo $row['economic_status']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <!--
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manageUsers<?php echo $user_ID; ?>">
                                                    <span class="d-lg-block d-lg-none d-xl-none">Edit</span><i class="fas fa-edit"></i>
                                                </button>
                                                -->
                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="manageUsers<?php echo $user_ID; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="" method="post">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Manage Learner</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">

                                                                    <div class="form-group">
                                                                        <label>Student Name</label>
                                                                        <input type="text" name="student_name" class="form-control" value="<?php echo $row['student_name']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Age</label>
                                                                        <input type="number" name="age" class="form-control" value="<?php echo $row['age']; ?>" required>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Sex</label>
                                                                        <select name="sex" class="form-control" required>
                                                                            <option value="Male" <?php echo ($row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                                            <option value="Female" <?php echo ($row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Term Attendance</label>
                                                                        <select name="quarterly_attendance" class="form-control" required>
                                                                            <option value="Excellent" <?php echo ($row['quarterly_attendance'] == 'Excellent') ? 'selected' : ''; ?>>Excellent - 0 absent per term</option>
                                                                            <option value="Satisfactory" <?php echo ($row['quarterly_attendance'] == 'Satisfactory') ? 'selected' : ''; ?>>Satisfactory - 1 to 3 days absent per term</option>
                                                                            <option value="Poor" <?php echo ($row['quarterly_attendance'] == 'Poor') ? 'selected' : ''; ?>>Poor - 4 or more days absent per term</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Grade Level</label><select class="form-control" name="grade_level">
                                                                            <?php
                                                                            // If grade_level_global is "All Levels", show all options
                                                                            if ($grade_level_global === "All Levels") {
                                                                                echo "<option value='All Levels' selected>All Grades</option>";
                                                                                for ($i = 1; $i <= 10; $i++) {
                                                                                    // Set the selected grade based on $grade_level_global if a specific grade is selected
                                                                                    $selected = (isset($_GET['grade_level']) && $_GET['grade_level'] == $i) ? 'selected' : '';
                                                                                    echo "<option value='$i' $selected>Grade $i</option>";
                                                                                }
                                                                            } else {
                                                                                // Show only the specific grade when $grade_level_global is set to a specific grade
                                                                                echo "<option value='$grade_level_global' selected>$grade_level_global</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Term</label>
                                                                        <select name="quarter" class="form-control" required>
                                                                            <option value="">Select Term</option>
                                                                            <?php 
                                                                            $currentTerm = (string)$row['quarter'];
                                                                            for ($i = 1; $i <= 3; $i++) {
                                                                                $selected = ($currentTerm === (string)$i) ? "selected" : "";
                                                                                echo "<option value='$i' $selected>Term $i</option>";
                                                                            }
                                                                            if (!in_array($currentTerm, ['1', '2', '3'], true)) {
                                                                                $escapedTerm = htmlspecialchars($currentTerm, ENT_QUOTES, 'UTF-8');
                                                                                echo "<option value='$escapedTerm' selected>Legacy term $escapedTerm</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Extra Curricular</label>
                                                                        <select name="extra_curricular" class="form-control" required>
                                                                            <option value="">Select Extra Curricular</option>
                                                                            <?php 
                                                                            $activities = ["Athlete", "Academic contest participant", "None"];
                                                                            foreach ($activities as $activity) {
                                                                                $selected = ($row['extra_curricular'] == $activity) ? "selected" : "";
                                                                                echo "<option value='$activity' $selected>$activity</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Economic Status</label>
                                                                        <select name="economic_status" class="form-control" required>
                                                                            <option value="">Select Economic Status</option>
                                                                            <?php 
                                                                            $statuses = [
                                                                                "Low" => "Low-Income Class - This group includes individuals and families with incomes below the poverty threshold or just above it. They often struggle to meet basic needs such as food, shelter, and education.",
                                                                                "Middle" => "Middle-Income Class - This group is further divided into lower middle, middle, and upper middle classes. They have more financial stability compared to the low-income class and can afford a more comfortable lifestyle, including better housing, education, and healthcare.",
                                                                                "High" => "High-Income Class - This group comprises individuals and families with significantly higher incomes, allowing them to enjoy a luxurious lifestyle with access to premium services and goods."
                                                                            ];
                                                                            foreach ($statuses as $key => $description) {
                                                                                $selected = ($row['economic_status'] == $key) ? "selected" : "";
                                                                                echo "<option value='$key' title='$description' $selected>$key</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label>Settlement</label>
                                                                        <select name="settlement" class="form-control" required>
                                                                            <option value="">Select Settlement Type</option>
                                                                            <?php 
                                                                            $settlements = [
                                                                                "Urban" => "People living in cities or highly urbanized areas.",
                                                                                "Rural" => "People living in less densely populated areas, such as towns and villages.",
                                                                                "Informal" => "Individuals or families living in areas without legal claim to the land, often in makeshift housing."
                                                                            ];
                                                                            foreach ($settlements as $key => $description) {
                                                                                $selected = ($row['settlement'] == $key) ? "selected" : "";
                                                                                echo "<option value='$key' title='$description' $selected>$key</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Physical/Mental Status</label>
                                                                        <select name="physical_mental_status" class="form-control" required>
                                                                            <option value="">Select Health Status</option>
                                                                            <?php 
                                                                            $healthStatuses = [
                                                                                "Excellent" => "Optimal health with no illness or health issues and exhibits strong mental well-being.",
                                                                                "Moderate" => "With minor health issues, moderate levels of stress and anxiety but well-managed.",
                                                                                "Poor" => "Have chronic health issues and high levels of stress, anxiety, or depression."
                                                                            ];
                                                                            foreach ($healthStatuses as $key => $description) {
                                                                                $selected = ($row['physical_mental_status'] == $key) ? "selected" : "";
                                                                                echo "<option value='$key' title='$description' $selected>$key</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>


                                                                    <div class="form-group">
                                                                        <label>Feeding Program</label>
                                                                        <select name="feeding_prog_receipt" class="form-control" required>
                                                                            <option value="Yes" <?php echo ($row['feeding_prog_receipt'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                                                                            <option value="No" <?php echo ($row['feeding_prog_receipt'] == 'No') ? 'selected' : ''; ?>>No</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label>Status</label>
                                                                        <select name="status" class="form-control" required>
                                                                            <option value="Active" <?php echo ($row['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                                                            <option value="Inactive" <?php echo ($row['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-success" name="updateprofileinfo">Update <i class="fas fa-edit"></i></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUsers<?php echo $user_ID; ?>"> <span class="d-lg-block d-lg-none d-xl-none">Delete</span><i class="fas fa-trash"></i> </button>
                            
                                            <form action="" method="post">                                   
                                              <div class="modal fade" id="deleteUsers<?php echo $user_ID; ?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Deleting Student Account</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <p>Are you sure you want to delete this Student Account?</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-end">
                                                        <input type="hidden" name="user_ID_Delete" id="user_ID_Delete" value="<?php echo $user_ID; ?>">
                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                      <button type="submit" class="btn btn-danger" id="deleteuser" name="deleteuser">Confirm</button>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Add Student Modal -->
<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Learner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Student Fields -->
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" name="student_nameadd" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Age</label>
                        <input type="number" name="ageadd" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Sex</label>
                        <select name="sexadd" class="form-control" required>
                            <option value="">Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
<div class="form-group">
    <label>Term</label>
    <select name="quarteradd" class="form-control" required>
        <option value="">Select Term</option>
        <option value="1">Term 1</option>
        <option value="2">Term 2</option>
        <option value="3">Term 3</option>
        
    </select>
</div>

<div class="form-group">
    <label>Grade Level</label>
<select class="form-control" name="grade_leveladd">
    <?php
    // If grade_level_global is "All Levels", show all options
    if ($grade_level_global === "All Levels") {
        echo "<option value='All Levels' selected>All Grades</option>";
        for ($i = 1; $i <= 10; $i++) {
            echo "<option value='$i'>Grade $i</option>";
        }
    } else {
        // Show only the specific grade when $grade_level_global is set to a specific grade
        echo "<option value='$grade_level_global' selected>$grade_level_global</option>";
    }
    ?>
</select>
</div>

<div class="form-group">
    <label>Term Attendance</label>
    <select name="quarterly_attendanceadd" class="form-control" required>
        <option value="">Select Attendance</option>
        <option value="Excellent">Excellent</option>
        <option value="Satisfactory">Satisfactory</option>
        <option value="Poor">Poor</option>
    </select>
</div>

<div class="form-group">
    <label>Extra Curricular</label>
    <select name="extra_curricularadd" class="form-control" required>
        <option value="">Select Extra Curricular</option>
        <option value="Athlete">Athlete</option>
        <option value="Academic Contest Participant">Academic Contest Participant</option>
        <option value="None">None</option>
    </select>
</div>

                    <div class="form-group">
                        <label>Economic Status</label>
                        <select name="economic_statusadd" class="form-control" required>
                            <option value="">Select Economic Status</option>
                            <option value="Low">Low Income</option>
                            <option value="Middle">Middle Income</option>
                            <option value="High">High Income</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Settlement</label>
                        <select name="settlementadd" class="form-control" required>
                            <option value="">Select Settlement Type</option>
                            <option value="Urban">Urban residents</option>
                            <option value="Rural">Rural residents</option>
                            <option value="Informal">Informal settlers</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Physical/Mental Status</label>
                        <select name="physical_mental_statusadd" class="form-control" required>
                            <option value="">Select Health Status</option>
                            <option value="Excellent">Excellent Health</option>
                            <option value="Moderate">Moderate Health</option>
                            <option value="Poor">Poor Health</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Feeding Program</label>
                        <select name="feeding_prog_receiptadd" class="form-control" required>
                            <option value="">Select Option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="statusadd" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" name="addStudent">
                        Save <i class="fas fa-save"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


    </section>

    <!-- /.content -->
</div>



<?php
include('includes/footer.php');
?>