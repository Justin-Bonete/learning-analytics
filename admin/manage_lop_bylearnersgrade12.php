<?php
   include('includes/header.php');
   
   
   
   $district = $_REQUEST['district'];
   $school_id = $_REQUEST['school_id'];

                                $school_name_query = mysqli_query($DB, "SELECT school_name FROM schools WHERE school_id = '$school_id' LIMIT 1");
                                $school_name_row = mysqli_fetch_assoc($school_name_query);
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
       $a = $_POST['a'];
       $b = $_POST['b'];
       $c = $_POST['c'];
       $d = $_POST['d'];
       $e = $_POST['e'];
       $f = $_POST['f'];
       $g = $_POST['g'];
       $h = $_POST['h'];
   
       $grade_level= mysqli_real_escape_string($DB, $_POST['grade_level']);
       $quarter = mysqli_real_escape_string($DB, $_POST['quarter']);
       // Sanitize and validate inputs (if needed)
       $learner_id = mysqli_real_escape_string($DB, $learner_id);
       $a = mysqli_real_escape_string($DB, $a);
       $b = mysqli_real_escape_string($DB, $b);
       $c = mysqli_real_escape_string($DB, $c);
       $d = mysqli_real_escape_string($DB, $d);
       $e = mysqli_real_escape_string($DB, $e);
       $f = mysqli_real_escape_string($DB, $f);
       $g = mysqli_real_escape_string($DB, $g);
       $h = mysqli_real_escape_string($DB, $h);
       // Update query to modify the learner's scores
       $sql = "UPDATE learners_grade SET 
                   grade_level = '$grade_level',
                   quarter = '$quarter',
                   a = '$a', 
                   b = '$b',
                   c = '$c', 
                   d = '$d', 
                   e = '$e', 
                   f = '$f', 
                   g = '$g', 
                   h = '$h'
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
       $a = mysqli_real_escape_string($DB, $_POST['a']);
       $b = mysqli_real_escape_string($DB, $_POST['b']);
       $c = mysqli_real_escape_string($DB, $_POST['c']);
       $d = mysqli_real_escape_string($DB, $_POST['d']);
       $e = mysqli_real_escape_string($DB, $_POST['e']);
       $f = mysqli_real_escape_string($DB, $_POST['f']);
       $g = mysqli_real_escape_string($DB, $_POST['g']);
       $h = mysqli_real_escape_string($DB, $_POST['h']);
   
       
       // Insert the data into the database
       $query = "INSERT INTO learners_grade (
           student_name, 
           school_id, 
           grade_level, 
           quarter,
           a, b, c, d, e, f, g, h
       ) VALUES (
           '$student_name',
           '$school_id',
           '$grade_level',
           '$quarter',
           '$a', '$b', '$c', '$d', '$e', '$f', '$g', '$h'
       )";
   
       // Execute the query
       if (mysqli_query($DB, $query)) {
               showSweetAlertSucced2("Success!", "Score has been added successfully.", "success");  
       } else {
           // If there is an error in the query
               showSweetAlertFailed2("Failed!", $error, "error");
       }
   }
        function showSweetAlertSucced2($tih, $message, $type) {
               echo "
               <script>
               setTimeout(function() {
                   Swal.fire({
                       tih: '$tih',
                       text: '$message',
                       icon: '$type',
                       confirmButtonText: 'OK'
                   }).then(function() {
                     window.location.href = 'manage_grades.php';
                   });
               }, 500); // Delay in milliseconds (e.g., 1000ms = 1 second)
               </script>";
       }
       function showSweetAlertFailed2($tih, $message, $type) {
                   echo "
                   <script>
                   setTimeout(function() {
                       Swal.fire({
                           tih: '$tih',
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
               <h1 class="m-0">Manage Grades  (School <?php echo $school_name_row['school_name']; ?>)</h1>
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
                <input type="hidden" name="school_id" id="school_id" value="<?php echo $school_id; ?>"/>
                    <div class="row mb-3">
                        <div class="col-md-3">
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
                        <div class="col-md-3" style="display:none;">
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
                        <div class="col-md-3">
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
                // Function to determine proficiency level
                function getProficiencyLevel($percentage) {
                    if ($percentage >= 90) return 'Highly Proficient (A)';
                    if ($percentage >= 85) return 'Proficient (P)';
                    if ($percentage >= 80) return 'Nearly Proficient (AP)';
                    if ($percentage >= 75) return 'Low Proficient (D)';
                    return 'Not Proficient (B)';
                }

                // Get current year
                $current_year = date("Y");

                // Get filter values
                $year_filter = isset($_GET['year']) && $_GET['year'] !== '' ? intval($_GET['year']) : $current_year;
                $grade_level_filter = isset($_GET['grade_level']) && $_GET['grade_level'] !== '' ? intval($_GET['grade_level']) : null;
                $quarter_filter = isset($_GET['quarter']) && $_GET['quarter'] !== '' ? intval($_GET['quarter']) : null;

                $sql_summary = "
                    SELECT 
                        -- Highly Proficient (90+)
                        COUNT(CASE WHEN a >= 90 THEN 1 END) AS hp_a,
                        COUNT(CASE WHEN b >= 90 THEN 1 END) AS hp_b,
                        COUNT(CASE WHEN c >= 90 THEN 1 END) AS hp_c,
                        COUNT(CASE WHEN d >= 90 THEN 1 END) AS hp_d,
                        COUNT(CASE WHEN e >= 90 THEN 1 END) AS hp_e,
                        COUNT(CASE WHEN f >= 90 THEN 1 END) AS hp_f,
                        COUNT(CASE WHEN g >= 90 THEN 1 END) AS hp_g,
                        COUNT(CASE WHEN h >= 90 THEN 1 END) AS hp_h,
                        COUNT(CASE WHEN i >= 90 THEN 1 END) AS hp_i,
                        COUNT(CASE WHEN j >= 90 THEN 1 END) AS hp_j,

                        -- Proficient (85-89)
                        COUNT(CASE WHEN a BETWEEN 85 AND 89 THEN 1 END) AS p_a,
                        COUNT(CASE WHEN b BETWEEN 85 AND 89 THEN 1 END) AS p_b,
                        COUNT(CASE WHEN c BETWEEN 85 AND 89 THEN 1 END) AS p_c,
                        COUNT(CASE WHEN d BETWEEN 85 AND 89 THEN 1 END) AS p_d,
                        COUNT(CASE WHEN e BETWEEN 85 AND 89 THEN 1 END) AS p_e,
                        COUNT(CASE WHEN f BETWEEN 85 AND 89 THEN 1 END) AS p_f,
                        COUNT(CASE WHEN g BETWEEN 85 AND 89 THEN 1 END) AS p_g,
                        COUNT(CASE WHEN h BETWEEN 85 AND 89 THEN 1 END) AS p_h,
                        COUNT(CASE WHEN i BETWEEN 85 AND 89 THEN 1 END) AS p_i,
                        COUNT(CASE WHEN j BETWEEN 85 AND 89 THEN 1 END) AS p_j,

                        -- Nearly Proficient (80-84)
                        COUNT(CASE WHEN a BETWEEN 80 AND 84 THEN 1 END) AS np_a,
                        COUNT(CASE WHEN b BETWEEN 80 AND 84 THEN 1 END) AS np_b,
                        COUNT(CASE WHEN c BETWEEN 80 AND 84 THEN 1 END) AS np_c,
                        COUNT(CASE WHEN d BETWEEN 80 AND 84 THEN 1 END) AS np_d,
                        COUNT(CASE WHEN e BETWEEN 80 AND 84 THEN 1 END) AS np_e,
                        COUNT(CASE WHEN f BETWEEN 80 AND 84 THEN 1 END) AS np_f,
                        COUNT(CASE WHEN g BETWEEN 80 AND 84 THEN 1 END) AS np_g,
                        COUNT(CASE WHEN h BETWEEN 80 AND 84 THEN 1 END) AS np_h,
                        COUNT(CASE WHEN i BETWEEN 80 AND 84 THEN 1 END) AS np_i,
                        COUNT(CASE WHEN j BETWEEN 80 AND 84 THEN 1 END) AS np_j,

                        -- Low Proficient (75-79)
                        COUNT(CASE WHEN a BETWEEN 75 AND 79 THEN 1 END) AS lp_a,
                        COUNT(CASE WHEN b BETWEEN 75 AND 79 THEN 1 END) AS lp_b,
                        COUNT(CASE WHEN c BETWEEN 75 AND 79 THEN 1 END) AS lp_c,
                        COUNT(CASE WHEN d BETWEEN 75 AND 79 THEN 1 END) AS lp_d,
                        COUNT(CASE WHEN e BETWEEN 75 AND 79 THEN 1 END) AS lp_e,
                        COUNT(CASE WHEN f BETWEEN 75 AND 79 THEN 1 END) AS lp_f,
                        COUNT(CASE WHEN g BETWEEN 75 AND 79 THEN 1 END) AS lp_g,
                        COUNT(CASE WHEN h BETWEEN 75 AND 79 THEN 1 END) AS lp_h,
                        COUNT(CASE WHEN i BETWEEN 75 AND 79 THEN 1 END) AS lp_i,
                        COUNT(CASE WHEN j BETWEEN 75 AND 79 THEN 1 END) AS lp_j,

                        -- Not Proficient (<75)
                        COUNT(CASE WHEN a < 75 THEN 1 END) AS npf_a,
                        COUNT(CASE WHEN b < 75 THEN 1 END) AS npf_b,
                        COUNT(CASE WHEN c < 75 THEN 1 END) AS npf_c,
                        COUNT(CASE WHEN d < 75 THEN 1 END) AS npf_d,
                        COUNT(CASE WHEN e < 75 THEN 1 END) AS npf_e,
                        COUNT(CASE WHEN f < 75 THEN 1 END) AS npf_f,
                        COUNT(CASE WHEN g < 75 THEN 1 END) AS npf_g,
                        COUNT(CASE WHEN h < 75 THEN 1 END) AS npf_h,
                        COUNT(CASE WHEN i < 75 THEN 1 END) AS npf_i,
                        COUNT(CASE WHEN j < 75 THEN 1 END) AS npf_j
                    FROM learners_grade_shs
                    WHERE 
                     YEAR(created_at) = $year_filter";

                // Apply filters
                if ($grade_level_filter) $sql_summary .= " AND grade_level = $grade_level_filter";
                if ($quarter_filter) $sql_summary .= " AND quarter = $quarter_filter";

                     if($school_id != 'All'){

                         $sql_summary .= " AND school_id = '$school_id'";
                     }

                // Execute query
                $query_summary = mysqli_query($DB, $sql_summary);
                $summary = mysqli_fetch_assoc($query_summary);
            ?>

            <?php
                // Base SQL query
                $sql = "
                    SELECT 
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

                // Group and order results
                $sql .= " GROUP BY year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";

                // Execute query
                $query = mysqli_query($DB, $sql);

                if (!$query) {
                    die("SQL Error: " . mysqli_error($DB)); // Debugging: Show error if query fails
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
                <table id="example2" class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>Proficiency Level</th>
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
                        <tr><td><b>Highly Proficient</b></td>
                            <td><?= $summary['hp_a'] ?></td>
                            <td><?= $summary['hp_b'] ?></td>
                            <td><?= $summary['hp_c'] ?></td>
                            <td><?= $summary['hp_d'] ?></td>
                            <td><?= $summary['hp_e'] ?></td>
                            <td><?= $summary['hp_f'] ?></td>
                            <td><?= $summary['hp_g'] ?></td>
                            <td><?= $summary['hp_h'] ?></td>
                            <td><?= $summary['hp_i'] ?></td>
                            <td><?= $summary['hp_j'] ?></td>
                        </tr>

                        <tr><td><b>Proficient</b></td>
                            <td><?= $summary['p_a'] ?></td>
                            <td><?= $summary['p_b'] ?></td>
                            <td><?= $summary['p_c'] ?></td>
                            <td><?= $summary['p_d'] ?></td>
                            <td><?= $summary['p_e'] ?></td>
                            <td><?= $summary['p_f'] ?></td>
                            <td><?= $summary['p_g'] ?></td>
                            <td><?= $summary['p_h'] ?></td>
                            <td><?= $summary['p_i'] ?></td>
                            <td><?= $summary['p_j'] ?></td>
                        </tr>

                        <tr><td><b>Nearly Proficient</b></td>
                            <td><?= $summary['np_a'] ?></td>
                            <td><?= $summary['np_b'] ?></td>
                            <td><?= $summary['np_c'] ?></td>
                            <td><?= $summary['np_d'] ?></td>
                            <td><?= $summary['np_e'] ?></td>
                            <td><?= $summary['np_f'] ?></td>
                            <td><?= $summary['np_g'] ?></td>
                            <td><?= $summary['np_h'] ?></td>
                            <td><?= $summary['np_i'] ?></td>
                            <td><?= $summary['np_j'] ?></td>
                        </tr>

                        <tr><td><b>Low Proficient</b></td>
                            <td><?= $summary['lp_a'] ?></td>
                            <td><?= $summary['lp_b'] ?></td>
                            <td><?= $summary['lp_c'] ?></td>
                            <td><?= $summary['lp_d'] ?></td>
                            <td><?= $summary['lp_e'] ?></td>
                            <td><?= $summary['lp_f'] ?></td>
                            <td><?= $summary['lp_g'] ?></td>
                            <td><?= $summary['lp_h'] ?></td>
                            <td><?= $summary['lp_i'] ?></td>
                            <td><?= $summary['lp_j'] ?></td>
                        </tr>

                        <tr><td><b>Not Proficient</b></td>
                            <td><?= $summary['npf_a'] ?></td>
                            <td><?= $summary['npf_b'] ?></td>
                            <td><?= $summary['npf_c'] ?></td>
                            <td><?= $summary['npf_d'] ?></td>
                            <td><?= $summary['npf_e'] ?></td>
                            <td><?= $summary['npf_f'] ?></td>
                            <td><?= $summary['npf_g'] ?></td>
                            <td><?= $summary['npf_h'] ?></td>
                            <td><?= $summary['npf_i'] ?></td>
                            <td><?= $summary['npf_j'] ?></td>
                        </tr>

                    </tbody>
                <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Grade Level</th>
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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                <td>{$row['year']}</td>
                                <td>{$row['grade_level']}</td>
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
                                ";
                                ?>

                                <?php 
                                echo "
                                
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
</div>
<div id="interventionsModal" class="modal fade" tabindex="-1" aria-labelledby="interventionsModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="max-width:100%; width:85%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-tih" id="interventionsModalLabel">Interventions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="interventionsContent">
          <!-- The intervention data will be inserted here dynamically -->
        </div>
      </div>
    </div>
  </div>
</div><script>
    $(document).ready(function() {
    // When the View Interventions link is clicked
    $('.view-interventions').on('click', function() {
        var school_name = $(this).data('school_name');
        var a = $(this).data('a');
        var b = $(this).data('b');
        var c = $(this).data('c');
        var d = $(this).data('d');
        var e = $(this).data('e');
        var f = $(this).data('f');
        var g = $(this).data('g');
        var h = $(this).data('h');

        // Make the AJAX request to generate the interventions
        $.ajax({
            url: 'generate_interventions.php',
            method: 'GET',
            data: {
                type: 'lop',
                school_name: school_name,
                a: a,
                b: b,
                c: c,
                d: d,
                e: e,
                f: f,
                g: g,
                h: h
            },
            success: function(rdonse) {
                // Insert the returned content into the modal body
                $('#interventionsContent').html(rdonse);
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