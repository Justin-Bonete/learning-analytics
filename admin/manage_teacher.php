<?php
if (!isset($DB)) {
    require_once __DIR__ . '/../includes/database_connection.php';
}

include('includes/header.php');


    $school_id = $_SESSION['school_id'] ?? '';
    $school_email = $_SESSION['email'] ?? '';
$teacherListUrl = 'manage_teacher.php';
    $teacherFilterKeys = ['district', 'school_id', 'grade_level', 'position', 'major'];
    $teacherFilterValues = [];
    foreach ($teacherFilterKeys as $filterKey) {
        $teacherFilterValues[$filterKey] = isset($_GET[$filterKey]) && is_string($_GET[$filterKey])
            ? trim($_GET[$filterKey])
            : '';
    }
    $activeTeacherFilters = array_filter($teacherFilterValues, function ($value) {
        return $value !== '';
    });
    if ($activeTeacherFilters) {
        $teacherListUrl .= '?' . http_build_query($activeTeacherFilters);
}
    
    
    // Add this near your other form actions
if(isset($_POST['resetPassword'])) {
    $user_ID = $_POST['user_ID'];
    $password = md5($_POST['newpassword']); // Reset to school ID as default password
    
    $query = "UPDATE teachers_profiling SET password = '$password' WHERE id = '$user_ID'";
    $result = mysqli_query($DB, $query);

    if ($result) {
        showSweetAlertSucced2("Success!", "Password has been reset successfully.", "success");  
    } else {
        $error = "Error resetting password: " . mysqli_error($DB);
        showSweetAlertFailed2("Failed!", $error, "error");
    }
}
    
    
    
if(isset($_POST['deleteuser']))
{
    $USER_IDS = $_POST['user_ID_Delete'];

    $query = "DELETE FROM teachers_profiling WHERE id = '$USER_IDS'";
    $result = mysqli_query($DB, $query);

    if ($result) {    
            unset($_POST['user_ID_Delete']);  
            unset($_POST['deleteuser']);         
        showSweetAlertSucced2("Success!", "User has been deleted successfully.", "success");  
    } else {
            unset($_POST['user_ID_Delete']); 
            unset($_POST['deleteuser']);  
        $error = "Error deleting user: " . mysqli_error($DB);
        showSweetAlertFailed2("Failed!", $error, "error");
    }

}
if (isset($_POST['updateprofileinfo'])) {
    $validation = 1;
    $userID = $_POST['user_id'];
    $teacher_name = $_POST['teacher_name'];
    $sex = $_POST['sex'];
    $years_exp = $_POST['years_exp'];
    $position = $_POST['position'];
    $grade_level = $_POST['grade_level'];
    $major = $_POST['major'];
    $education = $_POST['education'];
    $no_of_trainings = $_POST['no_of_trainings'];

    if ($validation == 1) {
        $query = "UPDATE teachers_profiling SET 
                    teacher_name = '$teacher_name',
                    sex = '$sex',
                    years_exp = '$years_exp',
                    position = '$position',
                    grade_level = '$grade_level',
                    major = '$major',
                    education = '$education',
                    no_of_trainings = '$no_of_trainings'
                  WHERE id = $userID";

        $result = mysqli_query($DB, $query);

        if ($result) {             
            unset($_POST['updateprofileinfo']);
            showSweetAlertSucced2("Success!", "Teacher profile has been updated successfully.", "success");  
        } else {
            $error = "Error updating profile: " . mysqli_error($DB);
            unset($_POST['updateprofileinfo']);
            showSweetAlertFailed2("Failed!", $error, "error");
        }
    }
}
if (isset($_POST['addTeacher'])) {
 $teacher_name = mysqli_real_escape_string($DB, $_POST['teacher_name']);
    $sex = mysqli_real_escape_string($DB, $_POST['sex']);
    $years_exp = (int) $_POST['years_exp']; // Ensure it's an integer
    $position = mysqli_real_escape_string($DB, $_POST['position']);
    $grade_level = mysqli_real_escape_string($DB, $_POST['grade_level']);
    $major = mysqli_real_escape_string($DB, $_POST['major']);
    $education = mysqli_real_escape_string($DB, $_POST['education']);
    $no_of_trainings = $_POST['no_of_trainings']; // Ensure it's an integer

    $emailaddress = $_POST['emailaddress']; 
    $password = md5($school_id);

    $insertQuery = "INSERT INTO teachers_profiling 
        (school_id,teacher_name, sex, years_exp, position, grade_level, major, education, no_of_trainings, created_by, email, password) 
        VALUES 
        ('$school_id','$teacher_name', '$sex', '$years_exp', '$position', '$grade_level', '$major', '$education', '$no_of_trainings', '$school_email','$emailaddress','$password')";

    if (mysqli_query($DB, $insertQuery)) {
        showSweetAlertSucced2("Success!", "New teacher added successfully.", "success");
    } else {
        $error = "Error: " . mysqli_error($DB);
        showSweetAlertFailed2("Failed!", $error, "error");
    }
}

     function showSweetAlertSucced2($title, $message, $type) {
            global $teacherListUrl;
            $redirectUrl = json_encode($teacherListUrl, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
            echo "
            <script>
            setTimeout(function() {
                Swal.fire({
                    title: '$title',
                    text: '$message',
                    icon: '$type',
                    confirmButtonText: 'OK'
                }).then(function() {
                  window.location.href = $redirectUrl;
                });
            }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
            </script>";
    }
    function showSweetAlertFailed2($title, $message, $type) {
                global $teacherListUrl;
                $redirectUrl = json_encode($teacherListUrl, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
                echo "
                <script>
                setTimeout(function() {
                    Swal.fire({
                        title: '$title',
                        text: '$message',
                        icon: '$type',
                        confirmButtonText: 'OK'
                    }).then(function() {
                      window.location.href = $redirectUrl;
                    });
                }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
                </script>";
    }

    
include('includes/topbar.php');
include('includes/sidebar.php');
include('includes/modals.php');

$districtMunicipalities = [
    'District 1' => [
        'Bangued',
    ],
    'District 2' => [
        'Bucay', 'Manabo',
    ],
    'District 3' => [
        'Dolores', 'Tayum',
    ],
    'District 4' => [
        'Lagangilang', 'Lacub', 'Licuan-Baay', 'Malibcong',
    ],
    'District 5' => [
        'La Paz', 'Lagayan', 'Danglas',
    ],
];
$districtOptions = array_combine(array_keys($districtMunicipalities), array_keys($districtMunicipalities));
$selectedDistrict = isset($districtMunicipalities[$teacherFilterValues['district']])
    ? $teacherFilterValues['district']
    : '';
$schoolOptionsQuery = mysqli_query($DB, "SELECT school_id, school_name, district FROM schools WHERE school_id IS NOT NULL AND school_id <> '' ORDER BY school_name ASC");
$schoolOptions = [];
while ($school = mysqli_fetch_assoc($schoolOptionsQuery)) {
    if ($selectedDistrict === '' || in_array((string)$school['district'], $districtMunicipalities[$selectedDistrict], true)) {
        $schoolOptions[(string)$school['school_id']] = $school;
    }
}

$selectedSchoolId = $teacherFilterValues['school_id'];
$selectedGradeLevel = $teacherFilterValues['grade_level'];
$selectedPosition = $teacherFilterValues['position'];
$selectedMajor = $teacherFilterValues['major'];
$showTeacherList = !empty($activeTeacherFilters);

$selectedSchoolId = isset($schoolOptions[$selectedSchoolId]) ? $selectedSchoolId : '';

function getTeacherFilterOptions($DB, $filterColumn, $filters, $districtMunicipalities) {
    $filterColumns = [
        'school_id' => 't.school_id',
        'grade_level' => 't.grade_level',
        'position' => 't.position',
    ];
    $conditions = ["t.`$filterColumn` IS NOT NULL", "t.`$filterColumn` <> ''"];
    foreach ($filters as $filterKey => $filterValue) {
        if ($filterValue !== '' && $filterKey === 'district') {
            $municipalities = $districtMunicipalities[$filterValue] ?? [];
            if ($municipalities) {
                $escapedMunicipalities = array_map(function ($municipality) use ($DB) {
                    return "'" . mysqli_real_escape_string($DB, $municipality) . "'";
                }, $municipalities);
                $conditions[] = 's.district IN (' . implode(', ', $escapedMunicipalities) . ')';
            } else {
                $conditions[] = '1 = 0';
            }
        } elseif ($filterValue !== '' && isset($filterColumns[$filterKey])) {
            $escapedValue = mysqli_real_escape_string($DB, $filterValue);
            $conditions[] = $filterColumns[$filterKey] . " = '$escapedValue'";
        }
    }

    $query = "SELECT DISTINCT t.`$filterColumn`
              FROM teachers_profiling t
              LEFT JOIN schools s ON s.school_id = t.school_id
              WHERE " . implode(' AND ', $conditions) . "
              ORDER BY t.`$filterColumn` ASC";
    $optionQuery = mysqli_query($DB, $query);
    if (!$optionQuery) {
        die('Unable to load teacher filter options: ' . mysqli_error($DB));
    }

    $options = [];
    while ($optionRow = mysqli_fetch_row($optionQuery)) {
        $options[] = $optionRow[0];
    }
    return $options;
}

$teacherFilterOptions['grade_level'] = getTeacherFilterOptions($DB, 'grade_level', [
    'district' => $selectedDistrict,
    'school_id' => $selectedSchoolId,
], $districtMunicipalities);
$selectedGradeLevel = in_array($selectedGradeLevel, $teacherFilterOptions['grade_level'], true) ? $selectedGradeLevel : '';

$teacherFilterOptions['position'] = getTeacherFilterOptions($DB, 'position', [
    'district' => $selectedDistrict,
    'school_id' => $selectedSchoolId,
    'grade_level' => $selectedGradeLevel,
], $districtMunicipalities);
$selectedPosition = in_array($selectedPosition, $teacherFilterOptions['position'], true) ? $selectedPosition : '';

$teacherFilterOptions['major'] = getTeacherFilterOptions($DB, 'major', [
    'district' => $selectedDistrict,
    'school_id' => $selectedSchoolId,
    'grade_level' => $selectedGradeLevel,
    'position' => $selectedPosition,
], $districtMunicipalities);
$selectedMajor = in_array($selectedMajor, $teacherFilterOptions['major'], true) ? $selectedMajor : '';
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper accent-blue">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Teachers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 accent-blue">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Manage Teachers</li>
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
            <?php if($_SESSION['is_superadmin'] == '1'){ ?>
<button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addTeacherModal">
    Add Teacher <i class="fas fa-plus"></i>
</button>
<?php } ?>
                    <form method="get" action="manage_teacher.php" class="form-inline mb-3">
                        <label for="teacherDistrictFilter" class="mr-2">District:</label>
                        <select name="district" id="teacherDistrictFilter" class="form-control mr-2 mb-2" onchange="this.form.submit()">
                            <option value="">All districts</option>
                            <?php foreach ($districtOptions as $district) { ?>
                                <option value="<?php echo htmlspecialchars($district, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedDistrict === $district ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($district, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label for="teacherSchoolFilter" class="mr-2">School:</label>
                        <select name="school_id" id="teacherSchoolFilter" class="form-control mr-2 mb-2" onchange="this.form.submit()">
                            <option value="">All schools</option>
                            <?php foreach ($schoolOptions as $schoolId => $school) { ?>
                                <option value="<?php echo htmlspecialchars((string)$schoolId, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedSchoolId === (string)$schoolId ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($school['school_name'] . ' - ' . $school['district'] . ' (' . $schoolId . ')', ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php } ?>
                        </select>
                        <label for="teacherGradeFilter" class="mr-2">Grade Level:</label>
                        <select name="grade_level" id="teacherGradeFilter" class="form-control mr-2 mb-2" onchange="this.form.submit()">
                            <option value="">All grade levels</option>
                            <?php foreach ($teacherFilterOptions['grade_level'] as $gradeLevel) { ?>
                                <option value="<?php echo htmlspecialchars($gradeLevel, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedGradeLevel === $gradeLevel ? 'selected' : ''; ?>><?php echo htmlspecialchars($gradeLevel, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php } ?>
                        </select>
                        <label for="teacherPositionFilter" class="mr-2">Position:</label>
                        <select name="position" id="teacherPositionFilter" class="form-control mr-2 mb-2" onchange="this.form.submit()">
                            <option value="">All positions</option>
                            <?php foreach ($teacherFilterOptions['position'] as $position) { ?>
                                <option value="<?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedPosition === $position ? 'selected' : ''; ?>><?php echo htmlspecialchars($position, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php } ?>
                        </select>
                        <label for="teacherMajorFilter" class="mr-2">Major:</label>
                        <select name="major" id="teacherMajorFilter" class="form-control mr-2 mb-2" onchange="this.form.submit()">
                            <option value="">All majors</option>
                            <?php foreach ($teacherFilterOptions['major'] as $major) { ?>
                                <option value="<?php echo htmlspecialchars($major, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $selectedMajor === $major ? 'selected' : ''; ?>><?php echo htmlspecialchars($major, ENT_QUOTES, 'UTF-8'); ?></option>
                            <?php } ?>
                        </select>
                        <button type="submit" class="btn btn-primary mr-2 mb-2">Filter</button>
                        <a href="manage_teacher.php" class="btn btn-secondary">Reset</a>
                    </form>
                    <?php if ($showTeacherList) { ?>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Sex</th>
            <th>Years of Experience</th>
            <th>Position</th>
            <th>Grade Level</th>
            <th>Major</th>
            <th>Education</th>
            <th>Trainings</th>
            <th>District</th>
            <th>School</th>
            <?php if($_SESSION['is_superadmin'] == '1'){ ?>
            <th>Action</th>
            <?php } ?>
        </tr>
                        </thead>
                        <tbody>

        <?php
        $i = 0;
        $districtCondition = '1 = 1';
        if ($selectedDistrict !== '') {
            $districtValues = array_map(function ($municipality) use ($DB) {
                return "'" . mysqli_real_escape_string($DB, $municipality) . "'";
            }, $districtMunicipalities[$selectedDistrict]);
            $districtCondition = 's.district IN (' . implode(', ', $districtValues) . ')';
        }
        $teacherStatement = $DB->prepare("
            SELECT t.*, s.district AS school_district, s.school_name
            FROM teachers_profiling t
            LEFT JOIN schools s ON s.school_id = t.school_id
            WHERE $districtCondition
              AND (? = '' OR t.school_id = ?)
              AND (? = '' OR t.grade_level = ?)
              AND (? = '' OR t.position = ?)
              AND (? = '' OR t.major = ?)
            ORDER BY t.teacher_name ASC
        ");
        $teacherStatement->bind_param(
            'ssssssss',
            $selectedSchoolId, $selectedSchoolId,
            $selectedGradeLevel, $selectedGradeLevel,
            $selectedPosition, $selectedPosition,
            $selectedMajor, $selectedMajor
        );
        $teacherStatement->execute();
        $teacherQuery = $teacherStatement->get_result();
        if (mysqli_num_rows($teacherQuery) > 0) {
            while ($row = mysqli_fetch_assoc($teacherQuery)) {
                $i++;
                $user_ID = $row['id']; // Changed to match teacher ID column
                
        ?>
                            <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $row['teacher_name']; ?></td>
            <td><?php echo $row['sex']; ?></td>
            <td><?php echo $row['years_exp']; ?></td>
            <td><?php echo $row['position']; ?></td>
            <td><?php echo $row['grade_level']; ?></td>
            <td><?php echo $row['major']; ?></td>
            <td><?php echo $row['education']; ?></td>
            <td><?php echo $row['no_of_trainings']; ?></td>
            <td><?php echo htmlspecialchars($row['school_district'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?php echo htmlspecialchars($row['school_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
            <?php if($_SESSION['is_superadmin'] == '1'){ ?>
                                <td align="center">
                                    <div class="btn-group">
                                        
                                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manageUsers<?php echo $user_ID; ?>"> <span class="d-lg-block d-lg-none d-xl-none">Edit</span><i class="fas fa-edit"></i> </button>
                            <div class="modal fade" id="manageUsers<?php echo $user_ID; ?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Manage User</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                                <div class="row">
                                                <div class="form-group  col-md-12">
                                                    <label for="teacher_name">Teacher Name</label>
                                                    <input type="text" name="teacher_name" class="form-control" value="<?php echo $row['teacher_name']; ?>">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="sex">Sex</label>
                                                    <select name="sex" class="form-control">
                                                        <option value="Male" <?php echo ($row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                                                        <option value="Female" <?php echo ($row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="years_exp">Years of Experience</label>
                                                    <input type="number" name="years_exp" class="form-control" value="<?php echo $row['years_exp']; ?>">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="position">Position</label><select name="position" class="form-control" required>
    <?php
    $positions = [
        "Teacher I", "Teacher II", "Teacher III", "Teacher IV", "Teacher V", "Teacher VI", "Teacher VII",
        "Master Teacher I", "Master Teacher II", "Master Teacher III", "Master Teacher IV", "Master Teacher V"
    ];
    foreach ($positions as $pos) {
        $selected = ($row['position'] === $pos) ? 'selected' : '';
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
            $selected = (($row['grade_level'] ?? '') == "Grade $i") ? 'selected' : '';
            echo "<option value='Grade $i' $selected>Grade $i</option>";
        }
        ?>
        <option value="Kinder" <?php if(($row['grade_level'] ?? '') == 'Kinder'){ echo 'selected'; } ?>>Kinder</option>
    </select>
</div>

                                                <div class="form-group col-md-6">
                                                    <label for="major">Major</label>
                                                    <input type="text" name="major" class="form-control" value="<?php echo $row['major']; ?>">
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
                                                    <input type="number" name="no_of_trainings" class="form-control" value="<?php echo $row['no_of_trainings']; ?>">
                                                </div>
                                            </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success" name="updateprofileinfo">Update <i class="fas fa-edit"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

        <!-- New Reset Password Button -->
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#resetPasswordModal<?php echo $user_ID; ?>">
            <span class="d-lg-block d-lg-none d-xl-none">Reset PW</span><i class="fas fa-key"></i>
        </button>
        <!-- Reset Password Modal -->
        <form action="" method="post">
            <div class="modal fade" id="resetPasswordModal<?php echo $user_ID; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Reset Password</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php  
                                $randomNumber = $user_ID . time() . rand(1000, 9999);
                                                                $randompassword = $randomNumber;
                            ?>
                            <p>Are you sure you want to reset the password for <?php echo $row['teacher_name']; ?>?</p>
                            <p>The password will be reset to (<?php echo $randompassword; ?>).</p>
                            <input type="hidden" name="user_ID" value="<?php echo $user_ID; ?>">
                            <input type="hidden" name="newpassword" value="<?php echo $randompassword; ?>" />
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning" name="resetPassword">Reset Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
                                           <!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUsers<?php echo $user_ID; ?>"> <span class="d-lg-block d-lg-none d-xl-none">Delete</span><i class="fas fa-trash"></i> </button>
                                                -->
                                            <form action="" method="post">                                   
                                              <div class="modal fade" id="deleteUsers<?php echo $user_ID; ?>">
                                                <div class="modal-dialog">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h4 class="modal-title">Deleting Teacher Account</h4>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <div class="modal-body">
                                                      <p>Are you sure you want to delete this Teacher Account?</p>
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
                                <?php } ?>
                            </tr> 
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php } else { ?>
                        <div class="alert alert-info mb-0">Choose one or more filters above to load the teacher list.</div>
                    <?php } ?>
                </div>
                <!-- /.card-body -->
            </div>
        </div><!-- /.container-fluid -->
<div class="modal fade" id="addTeacherModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post">
                <div class="modal-header">
                    <h4 class="modal-title">Add New Teacher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="teacher_name">Full Name</label>
                        <input type="text" name="teacher_name" class="form-control" required>
                    </div>
                    <div class="row">
                    <div class="form-group col-md-6">
                        <label for="sex">Sex</label>
                        <select name="sex" class="form-control" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="years_exp">Years of Experience</label>
                        <input type="number" name="years_exp" class="form-control" required>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="position">Position</label>
    <select name="position" class="form-control" required>
        <option value="" disabled selected>Select position</option>
        <option value="Teacher I">Teacher I</option>
        <option value="Teacher II">Teacher II</option>
        <option value="Teacher III">Teacher III</option>
        <option value="Teacher IV">Teacher IV</option>
        <option value="Teacher V">Teacher V</option>
        <option value="Teacher VI">Teacher VI</option>
        <option value="Teacher VII">Teacher VII</option>
        <option value="Master Teacher I">Master Teacher I</option>
        <option value="Master Teacher II">Master Teacher II</option>
        <option value="Master Teacher III">Master Teacher III</option>
        <option value="Master Teacher IV">Master Teacher IV</option>
        <option value="Master Teacher V">Master Teacher V</option>
    </select>
                    </div>
<div class="form-group col-md-6">
    <label for="grade_level">Grade Level</label>
    <select name="grade_level" class="form-control">
        <?php 
        for ($i = 1; $i <= 12; $i++) {
            $selected = (($row['grade_level'] ?? '') == "Grade $i") ? 'selected' : '';
            echo "<option value='Grade $i' $selected>Grade $i</option>";
        }
        ?>
        <option value="Kinder" <?php if(($row['grade_level'] ?? '') == 'Kinder'){ echo 'selected'; } ?>>Kinder</option>
    </select>
</div>

                    <div class="form-group  col-md-12">
                        <label for="major">Major/Specailization</label>
                        <input type="text" name="major" class="form-control" required>
                    </div>
<div class="form-group col-md-6">
    <label for="education">Education</label>
    <select name="education" class="form-control">
        <option value="Bachelor" >Bachelor</option>
        <option value="Master" >Master</option>
        <option value="Doctor" >Doctor</option>
    </select>
</div> 
                    <div class="form-group col-md-6">
                        <label for="no_of_trainings">Number of Trainings</label>
                        <input type="number" name="no_of_trainings" class="form-control" required>
                    </div>
                    <hr>
                    <div class="form-group col-md-12">
                        <label for="emailaddress">Email Address</label>
                        <input type="text" name="emailaddress" class="form-control" required>
                    </div>

                </div>
                </div>
                <center>
                    <small>Default password will be school ID</small></center>
                    <br>
                <div class="modal-footer justify-content-end">
                    <button type="submit" class="btn btn-primary" name="addTeacher">Save <i class="fas fa-save"></i></button>
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