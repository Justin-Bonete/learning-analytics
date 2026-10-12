<?php
   include('includes/header.php');
   
   if(isset($_POST['deleteuser']))
   {
       $USER_IDS = $_POST['user_ID_Delete'];
   
       $query = "DELETE FROM learners_score WHERE id = '$USER_IDS'";
       $result = mysqli_query($DB, $query);
   
       if ($result) {    
               unset($_POST['user_ID_Delete']);  
               unset($_POST['deleteuser']);         
           showSweetAlertSucced2("Success!", "Score has been deleted successfully.", "success");  
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
       
       $t_english = $_POST['t_english'];
       $t_filipino = $_POST['t_filipino'];
       $t_aralpan = $_POST['t_aralpan'];
       $t_esp = $_POST['t_esp'];
       $t_math = $_POST['t_math'];
       $t_science = $_POST['t_science'];
       $t_mapeh = $_POST['t_mapeh'];
       $t_tle = $_POST['t_tle'];
       
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
       $t_english = mysqli_real_escape_string($DB, $t_english);
       $t_filipino = mysqli_real_escape_string($DB, $t_filipino);
       $t_aralpan = mysqli_real_escape_string($DB, $t_aralpan);
       $t_esp = mysqli_real_escape_string($DB, $t_esp);
       $t_math = mysqli_real_escape_string($DB, $t_math);
       $t_science = mysqli_real_escape_string($DB, $t_science);
       $t_mapeh = mysqli_real_escape_string($DB, $t_mapeh);
       $t_tle = mysqli_real_escape_string($DB, $t_tle);
       
       // Update query to modify the learner's scores
       $sql = "UPDATE learners_score SET 
                   grade_level = '$grade_level',
                   quarter = '$quarter',
                   english = '$english', 
                   filipino = '$filipino',
                   aralpan = '$aralpan', 
                   esp = '$esp', 
                   math = '$math', 
                   science = '$science', 
                   mapeh = '$mapeh', 
                   tle = '$tle', 
                   t_english = '$t_english', 
                   t_filipino = '$t_filipino', 
                   t_aralpan = '$t_aralpan', 
                   t_esp = '$t_esp', 
                   t_math = '$t_math', 
                   t_science = '$t_science', 
                   t_mapeh = '$t_mapeh', 
                   t_tle = '$t_tle'
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
   
       
       // Total Scores
       $t_english = mysqli_real_escape_string($DB, $_POST['t_english']);
       $t_filipino = mysqli_real_escape_string($DB, $_POST['t_filipino']);
       $t_aralpan = mysqli_real_escape_string($DB, $_POST['t_aralpan']);
       $t_esp = mysqli_real_escape_string($DB, $_POST['t_esp']);
       $t_math = mysqli_real_escape_string($DB, $_POST['t_math']);
       $t_science = mysqli_real_escape_string($DB, $_POST['t_science']);
       $t_mapeh = mysqli_real_escape_string($DB, $_POST['t_mapeh']);
       $t_tle = mysqli_real_escape_string($DB, $_POST['t_tle']);
   
       // Insert the data into the database
       $query = "INSERT INTO learners_score (
           student_name, 
           school_id, 
           grade_level, 
           quarter,
           english, filipino, aralpan, esp, math, science, mapeh, tle, 
           t_english, t_filipino, t_aralpan, t_esp, t_math, t_science, t_mapeh, t_tle, created_by
       ) VALUES (
           '$student_name',
           '$school_id',
           '$grade_level',
           '$quarter',
           '$english', '$filipino', '$aralpan', '$esp', '$math', '$science', '$mapeh', '$tle',
           '$t_english', '$t_filipino', '$t_aralpan', '$t_esp', '$t_math', '$t_science', '$t_mapeh', '$t_tle','$school_email'
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
                     window.location.href = 'manage_scores.php';
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
                         window.location.href = 'manage_scores.php';
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
               <h1 class="m-0">Manage Scores</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6 accent-blue">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Manage Scores</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <style>
      .th{
      vertical-align: top !important;
      }
   </style>
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
                    echo "<option value='{$schoolRow['school_id']}' $selected>{$schoolRow['school_id']} | {$schoolRow['school_name']}</option>";
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
        <div class="col-md-2">
            <label for="grade_level">Select Grade Level:</label>
            <select class="form-control" name="grade_level">
                <option value="">All Grades</option>
                <?php
                for ($i = 1; $i <= 10; $i++) {
                    $selected = (isset($_GET['grade_level']) && $_GET['grade_level'] == $i) ? 'selected' : '';
                    echo "<option value='$i' $selected>Grade $i</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <label for="quarter">Select Term:</label>
            <select class="form-control" name="quarter">
                <option value="">All Terms</option>
                <?php
                for ($q = 1; $q <= 3; $q++) {
                    $selected = (isset($_GET['quarter']) && $_GET['quarter'] == $q) ? 'selected' : '';
                    echo "<option value='$q' $selected>Term $q</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="manage_scores.php" class="btn btn-secondary ml-2">Reset</a>
        </div>
    </div>
</form>
               <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>School Name</th>
            <th>Student Name</th>
            <th>Grade Level</th>
            <th>Term</th>
            <th>Year</th> <!-- Added Year Column -->
            <th>English</th>
            <th>Filipino</th>
            <th>Araling Panlipunan</th>
            <th>ESP</th>
            <th>Math</th>
            <th>Science</th>
            <th>MAPEH</th>
            <th>TLE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $counterstriker = 0;
        $whereClauses = ["school_id <> ''"]; // Base condition

// Apply Filters
if (!empty($_GET['school'])) {
    $whereClauses[] = "school_id = '" . intval($_GET['school']) . "'";
}
if (!empty($_GET['year'])) {
    $whereClauses[] = "YEAR(created_at) = '" . intval($_GET['year']) . "'";
}
if (!empty($_GET['grade_level'])) {
    $whereClauses[] = "grade_level = '" . intval($_GET['grade_level']) . "'";
}
if (!empty($_GET['quarter'])) {
    $whereClauses[] = "quarter = '" . intval($_GET['quarter']) . "'";
}

$whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// Fetch filtered records
$teacherQuery = mysqli_query($DB, "SELECT *, YEAR(created_at) AS year FROM learners_score $whereSQL");


        if (mysqli_num_rows($teacherQuery) > 0) {
            while ($row = mysqli_fetch_assoc($teacherQuery)) {
                $counterstriker++;
                $user_ID = $row['id'];

    $school_id = $row['school_id'];
    $school_name_query = mysqli_query($DB, "SELECT school_name FROM schools WHERE school_id = '$school_id'");
    $school_name_row = mysqli_fetch_assoc($school_name_query);
                // Calculate total scores and total items
                $total_score = $row['english'] + $row['filipino'] + $row['aralpan'] + 
                               $row['esp'] + $row['math'] + $row['science'] + 
                               $row['mapeh'] + $row['tle'];

                $total_items = $row['t_english'] + $row['t_filipino'] + $row['t_aralpan'] + 
                               $row['t_esp'] + $row['t_math'] + $row['t_science'] + 
                               $row['t_mapeh'] + $row['t_tle'];

                // Avoid division by zero
                $mps = ($total_items > 0) ? ($total_score / $total_items) * 100 : 0;
                ?>
                <tr>
                    <td><?php echo $counterstriker; ?></td>
                    <td><?php echo  $school_name_row['school_name']; ?></td>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row['grade_level']; ?></td>
                    <td><?php echo $row['quarter']; ?></td>
                    <td><?php echo $row['year']; ?></td> <!-- Display Year -->
                    <td><?php echo $row['english'] . ' / ' . $row['t_english']; ?></td>
                    <td><?php echo $row['filipino'] . ' / ' . $row['t_filipino']; ?></td>
                    <td><?php echo $row['aralpan'] . ' / ' . $row['t_aralpan']; ?></td>
                    <td><?php echo $row['esp'] . ' / ' . $row['t_esp']; ?></td>
                    <td><?php echo $row['math'] . ' / ' . $row['t_math']; ?></td>
                    <td><?php echo $row['science'] . ' / ' . $row['t_science']; ?></td>
                    <td><?php echo $row['mapeh'] . ' / ' . $row['t_mapeh']; ?></td>
                    <td><?php echo $row['tle'] . ' / ' . $row['t_tle']; ?></td>
                      
                     </tr>
                     <?php
                        }
                        }
                        ?>
                  </tbody>
               </table>
            </div>
            <!-- /.card-body -->
         </div>
      </div>
      <!-- /.container-fluid -->
      <!-- Modal for adding learner's scores -->
      <div class="modal fade" id="addScoreModal" tabindex="-1" role="dialog" aria-labelledby="addScoreModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <form action="" method="POST">
                  <div class="modal-header">
                     <h5 class="modal-title" id="addScoreModalLabel">Add Learner's Scores</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">
                     <div class="form-group">
                        <label for="student_name">Student</label>
                        <select name="student_name" id="student_name" class="form-control" required>
                        <?php
                           // Fetch students from the students table using $DB
                           $query = "SELECT * FROM students";
                           $result = mysqli_query($DB, $query);
                           
                           // Check if query execution is successful
                           if ($result) {
                               while ($row = mysqli_fetch_assoc($result)) {
                                   echo "<option value='{$row['student_name']}'>{$row['student_name']}</option>";
                               }
                           } else {
                               echo "<option disabled>No students found</option>";
                           }
                           ?>
                        </select>
                     </div>
                     <!--
                        <div class="form-group">
                            <label for="school_id">School ID</label>
                            <select name="school_id" id="school_id" class="form-control" required>
                                <option value="" disabled selected>Select School</option>
                                <?php
                           // Assume you have a DBection to the database
                           $query = "SELECT school_id, school_name FROM schools";
                           $result = mysqli_query($DB, $query);
                           while($row = mysqli_fetch_assoc($result)) {
                               echo "<option value='" . $row['school_id'] . "'>" . $row['school_name'] . "</option>";
                           }
                           ?>
                            </select>
                        </div>
                        -->
                     <!-- Grade Level (Dropdown from Grade 1 to Grade 12) -->
                     <div class="form-group">
                        <label for="grade_level">Grade Level</label>
                        <select name="grade_level" id="grade_level" class="form-control" required>
                           <option value="" disabled selected>Select Grade Level</option>
                           <option value="1">Grade 1</option>
                           <option value="2">Grade 2</option>
                           <option value="3">Grade 3</option>
                           <option value="4">Grade 4</option>
                           <option value="5">Grade 5</option>
                           <option value="6">Grade 6</option>
                           <option value="7">Grade 7</option>
                           <option value="8">Grade 8</option>
                           <option value="9">Grade 9</option>
                           <option value="10">Grade 10</option>
                           <option value="11">Grade 11</option>
                           <option value="12">Grade 12</option>
                        </select>
                     </div>
                     <!-- Term (Dropdown from 1 to 4) -->
                     <div class="form-group">
                        <label for="quarter">Term</label>
                        <select name="quarter" id="quarter" class="form-control" required>
                           <option value="" disabled selected>Select Term</option>
                           <option value="1">Term 1</option>
                           <option value="2">Term 2</option>
                           <option value="3">Term 3</option>
                           
                        </select>
                     </div>
                     <div class="row">
                        <div class="col-md-6 col-xs-6 col-sm-6">
                           <!-- English Scores -->
                           <div class="form-group">
                              <label for="english">English</label>
                              <input type="number" name="english" id="english" class="form-control" required>
                           </div>
                           <!-- Filipino Scores -->
                           <div class="form-group">
                              <label for="filipino">Filipino</label>
                              <input type="number" name="filipino" id="filipino" class="form-control" required>
                           </div>
                           <!-- Aralpan Scores -->
                           <div class="form-group">
                              <label for="aralpan">Aralpan</label>
                              <input type="number" name="aralpan" id="aralpan" class="form-control" required>
                           </div>
                           <!-- ESP Scores -->
                           <div class="form-group">
                              <label for="esp">ESP</label>
                              <input type="number" name="esp" id="esp" class="form-control" required>
                           </div>
                           <!-- Math Scores -->
                           <div class="form-group">
                              <label for="math">Math</label>
                              <input type="number" name="math" id="math" class="form-control" required>
                           </div>
                           <!-- Science Scores -->
                           <div class="form-group">
                              <label for="science">Science</label>
                              <input type="number" name="science" id="science" class="form-control" required>
                           </div>
                           <!-- MAPEH Scores -->
                           <div class="form-group">
                              <label for="mapeh">MAPEH</label>
                              <input type="number" name="mapeh" id="mapeh" class="form-control" required>
                           </div>
                           <!-- TLE Scores -->
                           <div class="form-group">
                              <label for="tle">TLE</label>
                              <input type="number" name="tle" id="tle" class="form-control" required>
                           </div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-sm-6">
                           <!-- Total Scores (for each subject) -->
                           <div class="form-group">
                              <label for="t_english">Total English Score</label>
                              <input type="number" name="t_english" id="t_english" class="form-control" required>
                           </div>
                           <div class="form-group">
                              <label for="t_filipino">Total Filipino Score</label>
                              <input type="number" name="t_filipino" id="t_filipino" class="form-control" required>
                           </div>
                           <div class="form-group">
                              <label for="t_aralpan">Total Aralpan Score</label>
                              <input type="number" name="t_aralpan" id="t_aralpan" class="form-control" required>
                           </div>
                           <div class="form-group">
                              <label for="t_esp">Total ESP Score</label>
                              <input type="number" name="t_esp" id="t_esp" class="form-control" required>
                           </div>
                           <div class="form-group">
                              <label for="t_math">Total Math Score</label>
                              <input type="number" name="t_math" id="t_math" class="form-control" required>
                           </div>
                           <div class="form-group">
                              <label for="t_science">Total Science Score</label>
                              <input type="number" name="t_science" id="t_science" class="form-control" required>
                           </div>
                           <div class="form-group">
                              <label for="t_mapeh">Total MAPEH Score</label>
                              <input type="number" name="t_mapeh" id="t_mapeh" class="form-control" required>
                           </div>
                           <div class="form-group">
                              <label for="t_tle">Total TLE Score</label>
                              <input type="number" name="t_tle" id="t_tle" class="form-control" required>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-primary" name="add_scores">Add Scores</button>
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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