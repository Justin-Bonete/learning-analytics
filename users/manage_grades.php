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
           english, filipino, aralpan, esp, math, science, mapeh, tle, created_by, district
       ) VALUES (
           '$student_name',
           '$school_id',
           '$grade_level',
           '$quarter',
           '$english', '$filipino', '$aralpan', '$esp', '$math', '$science', '$mapeh', '$tle', '$school_email', '$district'
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
                     window.location.href = 'manage_grades.php';
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
                         window.location.href = 'manage_grades.php';
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
               <button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addScoreModal">
               Add Grades <i class="fas fa-plus"></i>
               </button>
               <form method="GET" action="">
    <div class="row mb-3">
        <div class="col-md-3">
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
        <div class="col-md-3">
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
        <div class="col-md-3">
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
            <a href="manage_grades.php" class="btn btn-secondary ml-2">Reset</a>
        </div>
    </div>
</form>

<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Student Name</th>
            <th>School ID</th>
            <th>Grade Level</th>
            <th>Term</th>
            <th>Year</th>
            <th>English</th>
            <th>Filipino</th>
            <th>Araling Panlipunan</th>
            <th>ESP</th>
            <th>Math</th>
            <th>Science</th>
            <th>MAPEH</th>
            <th>TLE</th>
            <th>Action</th> 
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
$whereClauses = [];

// Add conditions based on selected filters
if (!empty($selected_year)) {
    $whereClauses[] = "YEAR(created_at) = '" . intval($selected_year) . "'";
}
if (!empty($_GET['grade_level'])) {
    $whereClauses[] = "grade_level = '" . intval($_GET['grade_level']) . "'";
}
if (!empty($_GET['quarter'])) {
    $whereClauses[] = "quarter = '" . intval($_GET['quarter']) . "'";
}

// Ensure school_id is always included
$whereClauses[] = "school_id = " . intval($school_id);

// Construct the WHERE clause
$whereSQL = !empty($whereClauses) ? 'WHERE ' . implode(' AND ', $whereClauses) : '';

// Final Query
$query = "SELECT *, YEAR(created_at) AS year FROM learners_grade $whereSQL";


        $counterstriker = 0;
        $result = mysqli_query($DB, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $counterstriker++;
                $user_ID = $row['id'];

                // Calculate total score
                $total_score = $row['english'] + $row['filipino'] + $row['aralpan'] +
                               $row['esp'] + $row['math'] + $row['science'] +
                               $row['mapeh'] + $row['tle'];

                $total_possible = 800; // Each subject is out of 100

                // Calculate overall percentage
                $overall_percentage = ($total_score / $total_possible) * 100;
                // Get overall proficiency level
                $overall_proficiency = getOverallProficiency($overall_percentage);
                ?>
                        <td><?php echo $counterstriker; ?></td>
                        <td><?php echo $row['student_name']; ?></td>
                        <td><?php echo $row['school_id']; ?></td>
                        <td><?php echo $row['grade_level']; ?></td>
                        <td><?php echo $row['quarter']; ?></td>
                    <td><?php echo $row['year']; ?></td> <!-- Display Year -->
                        <td><?php echo $row['english'] . ' / 100' ; ?></td>
                        <td><?php echo $row['filipino'] . ' / 100' ; ?></td>
                        <td><?php echo $row['aralpan'] . ' / 100' ; ?></td>
                        <td><?php echo $row['esp'] . ' / 100' ; ?></td>
                        <td><?php echo $row['math'] . ' / 100' ; ?></td>
                        <td><?php echo $row['science'] . ' / 100' ; ?></td>
                        <td><?php echo $row['mapeh'] . ' / 100' ; ?></td>
                        <td><?php echo $row['tle'] . ' / 100'; ?></td>
                        <td align="center">
                           <div class="btn-group">
                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#editScoreModal<?php echo $user_ID; ?>"> <span class="d-lg-block d-lg-none d-xl-none">Edit</span><i class="fas fa-edit"></i> </button>
                             
                              <!-- Modal for editing learner's scores -->
                              <div class="modal fade" id="editScoreModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editScoreModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <form action="" method="POST">
                                          <div class="modal-header">
                                             <h5 class="modal-title" id="editScoreModalLabel<?php echo $row['id']; ?>">Edit Learner's Grades</h5>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <input type="hidden" name="learner_id" value="<?php echo $row['id']; ?>">
                                             <!-- Grade Level (Dropdown from Grade 1 to Grade 12) -->
                                             <div class="form-group">
                                                <label for="grade_level">Grade Level</label>
                                                <select name="grade_level" id="grade_level_<?php echo $row['id']; ?>" class="form-control" required>
                                                    <option value="" disabled selected>Select Grade Level</option>
                                                    
                                                    <?php 
                                                    if (preg_match('/Grade (\d+)\b/', $_SESSION['grade_level'], $matches)) {  
                                                        $gradeNumber = $matches[1]; 
                                                    ?>
                                                        <option value="<?php echo $gradeNumber; ?>" selected><?php echo $_SESSION['grade_level']; ?></option>
                                                    <?php 
                                                    } else { 
                                                        $gradeLevels = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
                                                
                                                        foreach ($gradeLevels as $grade) {
                                                            $selected = (isset($row['grade_level']) && $row['grade_level'] == $grade) ? 'selected' : '';
                                                            echo "<option value='{$grade}' {$selected}>Grade {$grade}</option>";
                                                        }
                                                    }
                                                    ?>
                                                    </select>
                                             </div>
                                             <!-- Term (Dropdown from 1 to 4) -->
                                             <div class="form-group">
                                                <label for="quarter">Term</label>
                                                <select name="quarter" id="quarter_<?php echo $row['id']; ?>" class="form-control" required>
                                                   <option value="" disabled selected>Select Term</option>
                                                   <?php
                                                      $currentTerm = (string)$row['quarter'];
                                                      for ($i = 1; $i <= 3; $i++) {
                                                          $selected = ($currentTerm === (string)$i) ? 'selected' : '';
                                                          echo "<option value='{$i}' {$selected}>Term {$i}</option>";
                                                      }
                                                      if (!in_array($currentTerm, ['1', '2', '3'], true)) {
                                                          $escapedTerm = htmlspecialchars($currentTerm, ENT_QUOTES, 'UTF-8');
                                                          echo "<option value='{$escapedTerm}' selected>Legacy term {$escapedTerm}</option>";
                                                      }
                                                      ?>
                                                </select>
                                             </div>
                                             <div class="row">

                                                   <!-- English Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="english_<?php echo $row['id']; ?>">English</label>
                                                      <input type="number" name="english" id="english_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['english']; ?>" required>
                                                   </div>
                                                   <!-- Filipino Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="filipino_<?php echo $row['id']; ?>">Filipino</label>
                                                      <input type="number" name="filipino" id="filipino_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['filipino']; ?>" required>
                                                   </div>
                                                   <!-- Aralpan Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="aralpan_<?php echo $row['id']; ?>">Aralpan</label>
                                                      <input type="number" name="aralpan" id="aralpan_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['aralpan']; ?>" required>
                                                   </div>
                                                   <!-- ESP Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="esp_<?php echo $row['id']; ?>">ESP</label>
                                                      <input type="number" name="esp" id="esp_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['esp']; ?>" required>
                                                   </div>
                                                   <!-- Math Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="math_<?php echo $row['id']; ?>">Math</label>
                                                      <input type="number" name="math" id="math_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['math']; ?>" required>
                                                   </div>
                                                   <!-- Science Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="science_<?php echo $row['id']; ?>">Science</label>
                                                      <input type="number" name="science" id="science_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['science']; ?>" required>
                                                   </div>
                                                   <!-- MAPEH Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="mapeh_<?php echo $row['id']; ?>">MAPEH</label>
                                                      <input type="number" name="mapeh" id="mapeh_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['mapeh']; ?>" required>
                                                   </div>
                                                   <!-- TLE Scores -->
                                                   <div class="form-group col-md-6">
                                                      <label for="tle_<?php echo $row['id']; ?>">TLE</label>
                                                      <input type="number" name="tle" id="tle_<?php echo $row['id']; ?>" class="form-control" value="<?php echo $row['tle']; ?>" required>
                                                   </div>
                                             </div>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" class="btn btn-primary" name="update_scores">Update Grades</button>
                                             <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
                                             <h4 class="modal-title">Deleting Grade</h4>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <p>Are you sure you want to delete this Learners Grade?</p>
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
                     <h5 class="modal-title" id="addScoreModalLabel">Add Learner's Grades</h5>
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
                        <div class="col-md-12 col-xs-12 col-sm-12">
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