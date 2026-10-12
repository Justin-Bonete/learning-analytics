<?php
   include('includes/header.php');
   
   
   $district = $_REQUEST['district'];
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
           english, filipino, aralpan, esp, math, science, mapeh, tle
       ) VALUES (
           '$student_name',
           '$school_id',
           '$grade_level',
           '$quarter',
           '$english', '$filipino', '$aralpan', '$esp', '$math', '$science', '$mapeh', '$tle'
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
   ?><style>
    .view-interventions {
        display: inline-block;
        background: linear-gradient(135deg, #007bff, #0056b3); /* Blue Gradient */
        color: #fff !important;
        font-weight: bold;
        padding: 12px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
        width:100%;
    }

    .view-interventions:hover {
        background: linear-gradient(135deg, #0056b3, #003f7f);
        transform: translateY(-2px);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
    }

    .view-interventions:active {
        transform: translateY(1px);
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
    }
</style>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper accent-blue">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0">Manage Grades (Per School of <?php echo $district;?>)</h1>
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
                <input type="hidden" name="district" id="district" value="<?php echo $district; ?>"/>
                    <div class="row mb-3">

                     <div class="col-md-2">
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
                                $selected_year = isset($_GET['year']) ? intval($_GET['year']) : $current_year;

                                for ($y = $current_year; $y >= 2000; $y--) { // Adjust 2000 to your earliest data year
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
                                for ($i = 1; $i <= 12; $i++) {
                                    $selected = (isset($_GET['grade_level']) && $_GET['grade_level'] == $i) ? 'selected' : '';
                                    echo "<option value='$i' $selected>Grade $i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="quarter">Select Semester:</label>
                            <select class="form-control" name="quarter">
                                <option value="">All Semester</option>
                                <?php
                                for ($q = 1; $q <= 2; $q++) {
                                    $selected = (isset($_GET['quarter']) && $_GET['quarter'] == $q) ? 'selected' : '';
                                    echo "<option value='$q' $selected>Semester $q</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                            <a href="manage_lopgrade12.php" class="btn btn-secondary ml-2">Reset</a>
                        </div>
                    </div>
                </form>
<?php
// Define proficiency categories
$categories = [
    'Highly Proficient (A)' => [],
    'Proficient (P)' => [],
    'Nearly Proficient (AP)' => [],
    'Low Proficient (D)' => [],
    'Not Proficient (B)' => []
];

$subjects = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j'];

// Initialize counts to zero for each subject and category
foreach ($categories as $category => &$subjectCounts) {
    foreach ($subjects as $subject) {
        $subjectCounts[$subject] = 0;
    }
}
unset($subjectCounts); // Remove reference

// Function to determine proficiency level
function getProficiencyLevel($percentage) {
    if ($percentage >= 90) return 'Highly Proficient (A)';
    if ($percentage >= 85) return 'Proficient (P)';
    if ($percentage >= 80) return 'Nearly Proficient (AP)';
    if ($percentage >= 75) return 'Low Proficient (D)';
    return 'Not Proficient (B)';
}

// Get filter values
$current_year = date("Y");
                  // Get filter values
                  $school = isset($_GET['school']) && $_GET['school'] !== '' ? intval($_GET['school']) : null;
$year_filter = isset($_GET['year']) && $_GET['year'] !== '' ? intval($_GET['year']) : $current_year;
$grade_level_filter = isset($_GET['grade_level']) && $_GET['grade_level'] !== '' ? intval($_GET['grade_level']) : null;
$quarter_filter = isset($_GET['quarter']) && $_GET['quarter'] !== '' ? intval($_GET['quarter']) : null;

// Base SQL query
$sql = "
    SELECT 
        YEAR(created_at) AS year,
        grade_level,
        quarter,
        a, b, c, d, e, f, g, h,i, j
    FROM learners_grade_shs
    WHERE 
        created_at IS NOT NULL
    AND YEAR(created_at) = $year_filter";

// Apply filters
if ($grade_level_filter) {
    $sql .= " AND grade_level = $grade_level_filter";
}
if ($quarter_filter) {
    $sql .= " AND quarter = $quarter_filter";
}
                     if($district != 'All'){

                         $sql .= " AND district = '$district'";
                     }
                     

                     if ($school) {
                    
                     // Group and order results
                     $sql .= " GROUP BY year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
                     
                     }else{
                     
                     // Group and order results
                     $sql .= " GROUP BY school_id, year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
                     
                     }
// Execute query
$query = mysqli_query($DB, $sql);

if (!$query) {
    die("SQL Error: " . mysqli_error($DB)); // Debugging: Show error if query fails
}

// Process each row from the query
while ($row = mysqli_fetch_assoc($query)) {
    foreach ($subjects as $subject) {
        $category = getProficiencyLevel($row[$subject]);
        $categories[$category][$subject]++;
    }
}
?>


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
            <th>Subject J</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Media and Information Literacy</td>
            <td>Introduction to Philosophy of the Human Person</td>
            <td>Physical Education and Health 3</td>
            <td>Understanding Culture, Society, and Politics</td>
            <td>Physical Education and Health 2</td>
            <td>English for Academic and Professional Purposes</td>
            <td>Filipino sa Piling Larangan</td>
            <td>Practical Research II</td>
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
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Contemporary Philippine Arts from the Regions</td>
            <td>Physical Education and Health 4</td>
            <td>Empowering Technologies</td>
            <td>Inquiries, Investigation and Immersion</td>
            <td>Work Immersion/ research/Culminating Activity/Capstone</td>
            <td>SPECIALIZED SUBJECT 1</td>
            <td>SPECIALIZED SUBJECT 2</td>
        </tr>
    </tbody>
</table>

<br>
<!-- Display the table -->
<table id="example1" class="table table-bordered">
    <thead>
        <tr>
            <th>Category</th>
            <th>Subject A</th>
            <th>Subject B</th>
            <th>Subject C</th>
            <th>Subject D</th>
            <th>Subject E</th>
            <th>Subject F</th>
            <th>Subject G</th>
            <th>Subject H</th>
            <th>Subject I</th>
            <th>Subject J</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $category => $subjectCounts): ?>
            <tr>
                <td><?= $category ?></td>
                <td><?= implode('</td><td>', $subjectCounts) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>





            <?php
                // Base SQL query
                $sql = "
                    SELECT 
                    district,
                    school_id,
                        YEAR(created_at) AS year,
                        grade_level,
                        quarter,
                        ROUND(AVG(a), 2) AS avg_a,
                        ROUND(AVG(b), 2) AS avg_b,
                        ROUND(AVG(c), 2) AS avg_c,
                        ROUND(AVG(d), 2) AS avg_d,
                        ROUND(AVG(e), 2) AS avg_e,
                        ROUND(AVG(f), 2) AS avg_f,
                        ROUND(AVG(g), 2) AS avg_g,
                        ROUND(AVG(h), 2) AS avg_h,
                        ROUND(AVG(i), 2) AS avg_i,
                        ROUND(AVG(j), 2) AS avg_j
                    FROM learners_grade_shs
                    WHERE 
                     created_at IS NOT NULL
                    AND YEAR(created_at) = $year_filter";

                // Apply filters
                if ($grade_level_filter) {
                    $sql .= " AND grade_level = $grade_level_filter";
                }
                if ($quarter_filter) {
                    $sql .= " AND quarter = $quarter_filter";
                }

                     if($district != 'All'){

                         $sql .= " AND district = '$district'";
                     }
                     
                     if ($school) {
                    
                     // Group and order results
                     $sql .= " GROUP BY year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
                     
                     }else{
                     
                     // Group and order results
                     $sql .= " GROUP BY school_id, year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
                     
                     }
                // Execute query
                $query = mysqli_query($DB, $sql);

                if (!$query) {
                    die("SQL Error: " . mysqli_error($DB)); // Debugging: Show error if query fails
                }
            ?>
                <table id="example2" class="table table-bordered">
                    <thead>
                        <tr>
                        <th>School</th>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Subject A</th>
                            <th>Subject B</th>
                            <th>Subject C</th>
                            <th>Subject D</th>
                            <th>Subject E</th>
                            <th>Subject F</th>
                            <th>Subject G</th>
                            <th>Subject H</th>
                            <th>Subject I</th>
                            <th>Subject J</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($query)) {

                                $school_id = $row['school_id'];
                                $school_name_query = mysqli_query($DB, "SELECT school_name FROM schools WHERE school_id = '$school_id' LIMIT 1");
                                $school_name_row = mysqli_fetch_assoc($school_name_query);
                            echo "<tr>
                                <td>{$school_name_row['school_name']}</td>
                                <td>{$row['year']}</td>
                                <td>{$row['quarter']}</td>
                                <td>{$row['avg_a']}%<br><small><b>" . getProficiencyLevel($row['avg_a']) . "</b></small></td>
                                <td>{$row['avg_b']}%<br><small><b>" . getProficiencyLevel($row['avg_b']) . "</b></small></td>
                                <td>{$row['avg_c']}%<br><small><b>" . getProficiencyLevel($row['avg_c']) . "</b></small></td>
                                <td>{$row['avg_d']}%<br><small><b>" . getProficiencyLevel($row['avg_d']) . "</b></small></td>
                                <td>{$row['avg_e']}%<br><small><b>" . getProficiencyLevel($row['avg_e']) . "</b></small></td>
                                <td>{$row['avg_f']}%<br><small><b>" . getProficiencyLevel($row['avg_f']) . "</b></small></td>
                                <td>{$row['avg_g']}%<br><small><b>" . getProficiencyLevel($row['avg_g']) . "</b></small></td>
                                <td>{$row['avg_h']}%<br><small><b>" . getProficiencyLevel($row['avg_h']) . "</b></small></td>
                                <td>{$row['avg_i']}%<br><small><b>" . getProficiencyLevel($row['avg_i']) . "</b></small></td>
                                <td>{$row['avg_j']}%<br><small><b>" . getProficiencyLevel($row['avg_j']) . "</b></small></td>
                                <td><a class='view-interventions' href='manage_lop_bylearnersgrade12.php?district={$row['district']}&school_id={$row['school_id']}'>View Data</a> ";
                                ?>


                                <?php 
                                echo "
                                </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
         </div>
      </div>
   </section>
   <!-- /.content -->
</div><!-- Modal -->
<div id="interventionsModal" class="modal fade" tabindex="-1" aria-labelledby="interventionsModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:100%; width:85%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="interventionsModalLabel">Interventions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="interventionsContent">
          <!-- The intervention data will be inserted here dynamically -->
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
    // When the View Interventions link is clicked
    $('.view-interventions').on('click', function() {
        var school_name = $(this).data('school_name');
        var english = $(this).data('english');
        var filipino = $(this).data('filipino');
        var aralpan = $(this).data('aralpan');
        var esp = $(this).data('esp');
        var math = $(this).data('math');
        var science = $(this).data('science');
        var mapeh = $(this).data('mapeh');
        var tle = $(this).data('tle');

        // Make the AJAX request to generate the interventions
        $.ajax({
            url: 'generate_interventions.php',
            method: 'GET',
            data: {
                type: 'lop',
                school_name: school_name,
                english: english,
                filipino: filipino,
                aralpan: aralpan,
                esp: esp,
                math: math,
                science: science,
                mapeh: mapeh,
                tle: tle
            },
            success: function(response) {
                // Insert the returned content into the modal body
                $('#interventionsContent').html(response);
                // Show the modal
                $('#interventionsModal').modal('show');
            },
            error: function() {
                alert('Error loading interventions data.');
            }
        });
    });
});

</script>
<?php
   include('includes/footer.php');
   ?>