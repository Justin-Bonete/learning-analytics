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
    $status = $_POST['status'];

    if ($validation == 1) {
        $query = "UPDATE students SET 
                    student_name = '$student_name',
                    age = '$age',
                    sex = '$sex',
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
    $grade_level = mysqli_real_escape_string($DB, $_POST['grade_leveladd']);
    $status = mysqli_real_escape_string($DB, $_POST['statusadd']);

    $insertQuery = "INSERT INTO students 
        (school_id, student_name, age, sex, grade_level, status, created_by) 
        VALUES 
        ('$school_id', '$student_name', '$age', '$sex', '$grade_level', '$status', '$school_email')";

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
                  window.location.href = 'manage_kinder.php';
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
                      window.location.href = 'manage_kinder.php';
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
                    <h1 class="m-0">Manage Students</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 accent-blue">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Manage Students</li>
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
                        Add Student <i class="fas fa-plus"></i>
                    </button>
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Age</th>
                                <th>Sex</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ig1 = 0;
                            $studentQuery = mysqli_query($DB, "SELECT * FROM students WHERE school_id = '$school_id' AND grade_level = 'Kinder'");
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
                                        <td><?php echo $row['status']; ?></td>
                                        <td align="center">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manageUsers<?php echo $user_ID; ?>">
                                                    <span class="d-lg-block d-lg-none d-xl-none">Edit</span><i class="fas fa-edit"></i>
                                                </button>
                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="manageUsers<?php echo $user_ID; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <form action="" method="post">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title">Manage Student</h4>
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
                    <h4 class="modal-title">Add New Student</h4>
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
                        <label>Grade Level</label>
                        <select name="grade_leveladd" class="form-control" required>
                            <option value="Kinder">Kinder</option>
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