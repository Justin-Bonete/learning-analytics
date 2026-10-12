<?php
   include('includes/header.php');
   
       $school_id = $_SESSION['school_id'];
       $school_email = $_SESSION['email'];
       $district = $_SESSION['district'];
   
   if(isset($_POST['deleteuser']))
   {
       $USER_IDS = $_POST['user_ID_Delete'];
   
       $query = "DELETE FROM learners_score WHERE id = '$USER_IDS'";
       $result = mysqli_query($DB, $query);
   
       if ($result) {    
               unset($_POST['user_ID_Delete']);  
               unset($_POST['deleteuser']);         
           showSweetAlertSucced2("Success!", "Grade has been deleted successfully.", "success");  
       } else {
               unset($_POST['user_ID_Delete']); 
               unset($_POST['deleteuser']);  
           $error = "Error deleting user: " . mysqli_error($DB);
           showSweetAlertFailed2("Failed!", $error, "error");
       }
   
   }
   if (isset($_POST['update_scores'])) {
       // Fetch values from the form
       $learner_id = $_POST['learner_id'];
       $english = $_POST['english'];
       $filipino = $_POST['filipino'];
       $aralpan = $_POST['aralpan'];
       $esp = $_POST['esp'];
       $math = $_POST['math'];
       $science = $_POST['science'];
       $mapeh = $_POST['mapeh'];
       $tle = $_POST['tle'];
   
       $grade_level= mysqli_real_escape_string($DB, $_POST['grade_level']);
       $quarter = mysqli_real_escape_string($DB, $_POST['quarter']);
       // Sanitize and validate inputs (if needed)
       $learner_id = mysqli_real_escape_string($DB, $learner_id);
       $english = mysqli_real_escape_string($DB, $english);
       $filipino = mysqli_real_escape_string($DB, $filipino);
       $aralpan = mysqli_real_escape_string($DB, $aralpan);
       $esp = mysqli_real_escape_string($DB, $esp);
       $math = mysqli_real_escape_string($DB, $math);
       $science = mysqli_real_escape_string($DB, $science);
       $mapeh = mysqli_real_escape_string($DB, $mapeh);
       $tle = mysqli_real_escape_string($DB, $tle);
       // Update query to modify the learner's scores
       $sql = "UPDATE learners_grade SET 
                   grade_level = '$grade_level',
                   quarter = '$quarter',
                   english = '$english', 
                   filipino = '$filipino',
                   aralpan = '$aralpan', 
                   esp = '$esp', 
                   math = '$math', 
                   science = '$science', 
                   mapeh = '$mapeh', 
                   tle = '$tle'
               WHERE id = '$learner_id'";
   
       // Execute the query
       if (mysqli_query($DB, $sql)) {       
               unset($_POST['updateprofileinfo']);
               showSweetAlertSucced2("Success!", "Score has been updated successfully.", "success");  
           } else {
               $error = "Error updating profile: " . mysqli_error($DB);
               unset($_POST['updateprofileinfo']);
               showSweetAlertFailed2("Failed!", $error, "error");
           }
   }
   
   
   if (isset($_POST['add_scores']) && !in_array((string)($_POST['quarter'] ?? ''), ['1', '2', '3'], true)) {
       showSweetAlertFailed2('Invalid term', 'Only Terms 1, 2, and 3 are accepted for new records.', 'error');
       exit;
   }
   if (isset($_POST['add_scores'])) {
       // Fetch values from the form
     // Get the form data
       $student_name = mysqli_real_escape_string($DB, $_POST['student_name']);
       //$school_id = mysqli_real_escape_string($DB, $_POST['school_id']);
       
       $grade_level = mysqli_real_escape_string($DB, $_POST['grade_level']);
       $quarter = mysqli_real_escape_string($DB, $_POST['quarter']);
       
       // Subject scores
       $english = mysqli_real_escape_string($DB, $_POST['english']);
       $filipino = mysqli_real_escape_string($DB, $_POST['filipino']);
       $aralpan = mysqli_real_escape_string($DB, $_POST['aralpan']);
       $esp = mysqli_real_escape_string($DB, $_POST['esp']);
       $math = mysqli_real_escape_string($DB, $_POST['math']);
       $science = mysqli_real_escape_string($DB, $_POST['science']);
       $mapeh = mysqli_real_escape_string($DB, $_POST['mapeh']);
       $tle = mysqli_real_escape_string($DB, $_POST['tle']);
   
       
       // Insert the data into the database
       $query = "INSERT INTO learners_grade (
           student_name, 
           school_id, 
           grade_level, 
           quarter,
           english, filipino, aralpan, esp, math, science, mapeh, tle, created_by
       ) VALUES (
           '$student_name',
           '$school_id',
           '$grade_level',
           '$quarter',
           '$english', '$filipino', '$aralpan', '$esp', '$math', '$science', '$mapeh', '$tle', '$school_email'
       )";
   
       // Execute the query
       if (mysqli_query($DB, $query)) {
               showSweetAlertSucced2("Success!", "Score has been added successfully.", "success");  
       } else {
           // If there is an error in the query
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
                     window.location.href = 'manage_grades11.php';
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
                         window.location.href = 'manage_grades11.php';
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
               <h1 class="m-0">Manage Grades</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6 accent-blue">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Manage Grades</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <div class="card-body">
               <form method="GET" action="">
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="school">Select School:</label>
            <select class="form-control" name="school">
                <option value="">All Schools</option>
                <?php
                $schoolQuery = mysqli_query($DB, "SELECT * FROM schools ORDER BY school_name ASC");
                while ($schoolRow = mysqli_fetch_assoc($schoolQuery)) {
                    $selected = (isset($_GET['school']) && $_GET['school'] == $schoolRow['school_id']) ? 'selected' : '';
                    echo "<option value='{$schoolRow['school_id']}' $selected>{$schoolRow['school_name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="year">Select Year:</label>
            <select class="form-control" name="year">
                <?php
                $current_year = date("Y");
                $selected_year = isset($_GET['year']) ? intval($_GET['year']) : '';

                echo "<option value=''>All Years</option>";
                for ($y = $current_year; $y >= 2000; $y--) { 
                    $selected = ($selected_year == $y) ? 'selected' : '';
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2" style="display:none;">
            <label for="grade_level">Select Grade Level:</label>
            <select class="form-control" name="grade_level">
                <option value="">All Grades</option>
                <?php
                for ($i = 11; $i <= 12; $i++) {
                    $selected = (isset($_GET['grade_level']) && $_GET['grade_level'] == $i) ? 'selected' : '';
                    echo "<option value='$i' $selected>Grade $i</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
   <label for="quarter">Select Term:</label> <!-- ✅ Updated Label -->
<select class="form-control" name="quarter">
    <option value="">All Terms</option> <!-- ✅ Updated Text -->
    <?php
    for ($q = 1; $q <= 3; $q++) { // ✅ Now iterates from Q1 to Q4
        $selected = (isset($_GET['quarter']) && $_GET['quarter'] == $q) ? 'selected' : '';
        echo "<option value='$q' $selected>Term $q</option>"; // ✅ Updated Option Text
    }
    ?>
</select>

        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="manage_grades11.php" class="btn btn-secondary ml-2">Reset</a>
        </div>
    </div>
</form>

<label>First Semester Subjects</label>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Subject A</th>
            <th>Subject B</th>
            <th>Subject C</th>
            <th>Subject D</th>
            <th>Subject E</th>
            <th>Subject F</th>
            <th>Subject G</th>
            <th>Subject H</th>
            <th>Subject I</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Oral Communication</td>
            <td>Komunikasyon at Pananaliksik sa Wika at Kulturang Pilipino</td>
            <td>General Mathematics</td>
            <td>Personal Development/ Pansariling Kaunlaran</td>
            <td>Earth and Life Science</td>
            <td>Physical Education and Health 1</td>
            <td>Etrepreneurship</td>
            <td>SPECIALIZED SUBJECT 1</td>
            <td>SPECIALIZED SUBJECT 2</td>
        </tr>
    </tbody>
</table>
<br>
<label>Second Semester Subjects</label>
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Subject A</th>
            <th>Subject B</th>
            <th>Subject C</th>
            <th>Subject D</th>
            <th>Subject E</th>
            <th>Subject F</th>
            <th>Subject G</th>
            <th>Subject H</th>
            <th>Subject I</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Reading and Writing</td>
            <td>Pagbasa at Pagsusuri ng Iba’t Ibang Teksto Tungo sa Pananaliksik</td>
            <td>21st Century Literature from the Philippines and the World</td>
            <td>Statistics and Probability</td>
            <td>Physical Science</td>
            <td>Physical Education and Health 2</td>
            <td>Practical Research I</td>
            <td>SPECIALIZED SUBJECT 1</td>
            <td>SPECIALIZED SUBJECT 2</td>
        </tr>
    </tbody>
</table>

<br>
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>School Name</th>
            <th>Student Name</th>
            <th>Term</th>
            <th>Year</th>
            <th>Subject A</th>
            <th>Subject B</th>
            <th>Subject C</th>
            <th>Subject D</th>
            <th>Subject E</th>
            <th>Subject F</th>
            <th>Subject G</th>
            <th>Subject H</th>
            <th>Subject I</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Function to determine proficiency level
        function getOverallProficiency($percentage) {
            if ($percentage >= 90) return 'Highly Proficient (A)';
            if ($percentage >= 85) return 'Proficient (P)';
            if ($percentage >= 80) return 'Nearly Proficient (AP)';
            if ($percentage >= 75) return 'Low Proficient (D)';
            return 'Not Proficient (B)';
        }
$whereClauses = ["school_id <> ''"]; // Base condition

// Apply Filters
if (!empty($_GET['school'])) {
    $whereClauses[] = "school_id = '" . intval($_GET['school']) . "'";
}
        if (!empty($selected_year)) {
            $whereClauses[] = "YEAR(created_at) = '$selected_year'";
        }

            $whereClauses[] = "grade_level = '11'";
        
        if (!empty($_GET['quarter'])) {
            $whereClauses[] = "quarter = '" . intval($_GET['quarter']) . "'";
        }
// Ensure school_id is always included
$whereClauses[] = "school_id = " . intval($school_id);

        $whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

        $counterstriker = 0;
        $query = "SELECT *, YEAR(created_at) AS year FROM learners_grade_shs $whereSQL";
        $result = mysqli_query($DB, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $counterstriker++;
                $user_ID = $row['id'];

    $school_id = $row['school_id'];
    $school_name_query = mysqli_query($DB, "SELECT school_name FROM schools WHERE school_id = '$school_id'");
    $school_name_row = mysqli_fetch_assoc($school_name_query);
                // Calculate total score
                $total_score = $row['a'] + $row['b'] + $row['c'] +
                               $row['d'] + $row['e'] + $row['f'] +
                               $row['g'] + $row['h'];

                $total_possible = 800; // Each subject is out of 100

                // Calculate overall percentage
                $overall_percentage = ($total_score / $total_possible) * 100;
                // Get overall proficiency level
                $overall_proficiency = getOverallProficiency($overall_percentage);
                ?>
                        <td><?php echo $counterstriker; ?></td>
                        <td><?php echo $school_name_row['school_name']; ?>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['quarter']; ?></td>
                    <td><?php echo $row['year']; ?></td> <!-- Display Year -->
                        <td><?php echo $row['a'] . ' / 100' ; ?></td>
                        <td><?php echo $row['b'] . ' / 100' ; ?></td>
                        <td><?php echo $row['c'] . ' / 100' ; ?></td>
                        <td><?php echo $row['d'] . ' / 100' ; ?></td>
                        <td><?php echo $row['e'] . ' / 100' ; ?></td>
                        <td><?php echo $row['f'] . ' / 100' ; ?></td>
                        <td><?php echo $row['g'] . ' / 100' ; ?></td>
                        <td><?php echo $row['h'] . ' / 100'; ?></td>
                        <td><?php echo $row['i'] . ' / 100'; ?></td>
                    
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
   </section>
   <!-- /.content -->
</div>
<?php
   include('includes/footer.php');
   ?>