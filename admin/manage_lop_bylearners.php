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
                        <div class="col-md-3">
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
                            <a href="manage_lop.php" class="btn btn-secondary ml-2">Reset</a>
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
                        COUNT(CASE WHEN english >= 90 THEN 1 END) AS hp_english,
                        COUNT(CASE WHEN filipino >= 90 THEN 1 END) AS hp_filipino,
                        COUNT(CASE WHEN aralpan >= 90 THEN 1 END) AS hp_aralpan,
                        COUNT(CASE WHEN esp >= 90 THEN 1 END) AS hp_esp,
                        COUNT(CASE WHEN math >= 90 THEN 1 END) AS hp_math,
                        COUNT(CASE WHEN science >= 90 THEN 1 END) AS hp_science,
                        COUNT(CASE WHEN mapeh >= 90 THEN 1 END) AS hp_mapeh,
                        COUNT(CASE WHEN tle >= 90 THEN 1 END) AS hp_tle,

                        -- Proficient (85-89)
                        COUNT(CASE WHEN english BETWEEN 85 AND 89 THEN 1 END) AS p_english,
                        COUNT(CASE WHEN filipino BETWEEN 85 AND 89 THEN 1 END) AS p_filipino,
                        COUNT(CASE WHEN aralpan BETWEEN 85 AND 89 THEN 1 END) AS p_aralpan,
                        COUNT(CASE WHEN esp BETWEEN 85 AND 89 THEN 1 END) AS p_esp,
                        COUNT(CASE WHEN math BETWEEN 85 AND 89 THEN 1 END) AS p_math,
                        COUNT(CASE WHEN science BETWEEN 85 AND 89 THEN 1 END) AS p_science,
                        COUNT(CASE WHEN mapeh BETWEEN 85 AND 89 THEN 1 END) AS p_mapeh,
                        COUNT(CASE WHEN tle BETWEEN 85 AND 89 THEN 1 END) AS p_tle,

                        -- Nearly Proficient (80-84)
                        COUNT(CASE WHEN english BETWEEN 80 AND 84 THEN 1 END) AS np_english,
                        COUNT(CASE WHEN filipino BETWEEN 80 AND 84 THEN 1 END) AS np_filipino,
                        COUNT(CASE WHEN aralpan BETWEEN 80 AND 84 THEN 1 END) AS np_aralpan,
                        COUNT(CASE WHEN esp BETWEEN 80 AND 84 THEN 1 END) AS np_esp,
                        COUNT(CASE WHEN math BETWEEN 80 AND 84 THEN 1 END) AS np_math,
                        COUNT(CASE WHEN science BETWEEN 80 AND 84 THEN 1 END) AS np_science,
                        COUNT(CASE WHEN mapeh BETWEEN 80 AND 84 THEN 1 END) AS np_mapeh,
                        COUNT(CASE WHEN tle BETWEEN 80 AND 84 THEN 1 END) AS np_tle,

                        -- Low Proficient (75-79)
                        COUNT(CASE WHEN english BETWEEN 75 AND 79 THEN 1 END) AS lp_english,
                        COUNT(CASE WHEN filipino BETWEEN 75 AND 79 THEN 1 END) AS lp_filipino,
                        COUNT(CASE WHEN aralpan BETWEEN 75 AND 79 THEN 1 END) AS lp_aralpan,
                        COUNT(CASE WHEN esp BETWEEN 75 AND 79 THEN 1 END) AS lp_esp,
                        COUNT(CASE WHEN math BETWEEN 75 AND 79 THEN 1 END) AS lp_math,
                        COUNT(CASE WHEN science BETWEEN 75 AND 79 THEN 1 END) AS lp_science,
                        COUNT(CASE WHEN mapeh BETWEEN 75 AND 79 THEN 1 END) AS lp_mapeh,
                        COUNT(CASE WHEN tle BETWEEN 75 AND 79 THEN 1 END) AS lp_tle,

                        -- Not Proficient (<75)
                        COUNT(CASE WHEN english < 75 THEN 1 END) AS npf_english,
                        COUNT(CASE WHEN filipino < 75 THEN 1 END) AS npf_filipino,
                        COUNT(CASE WHEN aralpan < 75 THEN 1 END) AS npf_aralpan,
                        COUNT(CASE WHEN esp < 75 THEN 1 END) AS npf_esp,
                        COUNT(CASE WHEN math < 75 THEN 1 END) AS npf_math,
                        COUNT(CASE WHEN science < 75 THEN 1 END) AS npf_science,
                        COUNT(CASE WHEN mapeh < 75 THEN 1 END) AS npf_mapeh,
                        COUNT(CASE WHEN tle < 75 THEN 1 END) AS npf_tle
                    FROM learners_grade
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
                        ROUND(AVG(english), 2) AS avg_english,
                        ROUND(AVG(filipino), 2) AS avg_filipino,
                        ROUND(AVG(aralpan), 2) AS avg_aralpan,
                        ROUND(AVG(esp), 2) AS avg_esp,
                        ROUND(AVG(math), 2) AS avg_math,
                        ROUND(AVG(science), 2) AS avg_science,
                        ROUND(AVG(mapeh), 2) AS avg_mapeh,
                        ROUND(AVG(tle), 2) AS avg_tle
                    FROM learners_grade
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
                <table id="example2" class="table table-bordered" >
                    <thead>
                        <tr>
                            <th>Proficiency Level</th>
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
                        <tr><td><b>Highly Proficient</b></td>
                            <td><?= $summary['hp_english'] ?></td>
                            <td><?= $summary['hp_filipino'] ?></td>
                            <td><?= $summary['hp_aralpan'] ?></td>
                            <td><?= $summary['hp_esp'] ?></td>
                            <td><?= $summary['hp_math'] ?></td>
                            <td><?= $summary['hp_science'] ?></td>
                            <td><?= $summary['hp_mapeh'] ?></td>
                            <td><?= $summary['hp_tle'] ?></td>
                        </tr>

                        <tr><td><b>Proficient</b></td>
                            <td><?= $summary['p_english'] ?></td>
                            <td><?= $summary['p_filipino'] ?></td>
                            <td><?= $summary['p_aralpan'] ?></td>
                            <td><?= $summary['p_esp'] ?></td>
                            <td><?= $summary['p_math'] ?></td>
                            <td><?= $summary['p_science'] ?></td>
                            <td><?= $summary['p_mapeh'] ?></td>
                            <td><?= $summary['p_tle'] ?></td>
                        </tr>

                        <tr><td><b>Nearly Proficient</b></td>
                            <td><?= $summary['np_english'] ?></td>
                            <td><?= $summary['np_filipino'] ?></td>
                            <td><?= $summary['np_aralpan'] ?></td>
                            <td><?= $summary['np_esp'] ?></td>
                            <td><?= $summary['np_math'] ?></td>
                            <td><?= $summary['np_science'] ?></td>
                            <td><?= $summary['np_mapeh'] ?></td>
                            <td><?= $summary['np_tle'] ?></td>
                        </tr>

                        <tr><td><b>Low Proficient</b></td>
                            <td><?= $summary['lp_english'] ?></td>
                            <td><?= $summary['lp_filipino'] ?></td>
                            <td><?= $summary['lp_aralpan'] ?></td>
                            <td><?= $summary['lp_esp'] ?></td>
                            <td><?= $summary['lp_math'] ?></td>
                            <td><?= $summary['lp_science'] ?></td>
                            <td><?= $summary['lp_mapeh'] ?></td>
                            <td><?= $summary['lp_tle'] ?></td>
                        </tr>

                        <tr><td><b>Not Proficient</b></td>
                            <td><?= $summary['npf_english'] ?></td>
                            <td><?= $summary['npf_filipino'] ?></td>
                            <td><?= $summary['npf_aralpan'] ?></td>
                            <td><?= $summary['npf_esp'] ?></td>
                            <td><?= $summary['npf_math'] ?></td>
                            <td><?= $summary['npf_science'] ?></td>
                            <td><?= $summary['npf_mapeh'] ?></td>
                            <td><?= $summary['npf_tle'] ?></td>
                        </tr>

                    </tbody>
                <table id="example1" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Grade Level</th>
                            <th>Term</th>
                            <th>English</th>
                            <th>Filipino</th>
                            <th>Araling Panlipunan</th>
                            <th>ESP</th>
                            <th>Math</th>
                            <th>Science</th>
                            <th>MAPEH</th>
                            <th>TLE</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>
                                <td>{$row['year']}</td>
                                <td>{$row['grade_level']}</td>
                                <td>{$row['quarter']}</td>
                                <td>{$row['avg_english']}%<br><small><b>" . getProficiencyLevel($row['avg_english']) . "</b></small></td>
                                <td>{$row['avg_filipino']}%<br><small><b>" . getProficiencyLevel($row['avg_filipino']) . "</b></small></td>
                                <td>{$row['avg_aralpan']}%<br><small><b>" . getProficiencyLevel($row['avg_aralpan']) . "</b></small></td>
                                <td>{$row['avg_esp']}%<br><small><b>" . getProficiencyLevel($row['avg_esp']) . "</b></small></td>
                                <td>{$row['avg_math']}%<br><small><b>" . getProficiencyLevel($row['avg_math']) . "</b></small></td>
                                <td>{$row['avg_science']}%<br><small><b>" . getProficiencyLevel($row['avg_science']) . "</b></small></td>
                                <td>{$row['avg_mapeh']}%<br><small><b>" . getProficiencyLevel($row['avg_mapeh']) . "</b></small></td>
                                <td>{$row['avg_tle']}%<br><small><b>" . getProficiencyLevel($row['avg_tle']) . "</b></small></td>
                                <td>";
                                ?>

                                     <a href="javascript:void(0);"  class="view-interventions" data-school_name="<?php echo $school_name_row['school_name']; ?>"
                                          data-english="<?php echo $row['avg_english']; ?>"
                                         data-filipino="<?php echo $row['avg_filipino']; ?>"
                                         data-aralpan="<?php echo $row['avg_aralpan']; ?>"
                                         data-esp="<?php echo $row['avg_esp']; ?>"
                                         data-math="<?php echo $row['avg_math']; ?>"
                                         data-science="<?php echo $row['avg_science']; ?>"
                                         data-mapeh="<?php echo $row['avg_mapeh']; ?>"
                                         data-tle="<?php echo $row['avg_tle']; ?>">Generate Interventions</a>
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
</div>
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
<!-- jQuery (required if you're using jQuery code) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Function to close the modal using Bootstrap's method
function closeModal() {
  var modal = new bootstrap.Modal(document.getElementById('interventionsModal'));
  modal.hide();
}
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