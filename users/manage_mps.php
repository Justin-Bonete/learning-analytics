<?php
   include('includes/header.php');
   
   
       $school_id = $_SESSION['school_id'];
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
           t_english, t_filipino, t_aralpan, t_esp, t_math, t_science, t_mapeh, t_tle
       ) VALUES (
           '$student_name',
           '$school_id',
           '$grade_level',
           '$quarter',
           '$english', '$filipino', '$aralpan', '$esp', '$math', '$science', '$mapeh', '$tle',
           '$t_english', '$t_filipino', '$t_aralpan', '$t_esp', '$t_math', '$t_science', '$t_mapeh', '$t_tle'
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
               <h1 class="m-0">Manage Mean Percentage Score</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6 accent-blue">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Manage Mean Percentage Score</li>
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
   </style><style>
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
   <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
<form method="GET" action="">
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
            <a href="manage_mps.php" class="btn btn-secondary ml-2">Reset</a>
        </div>
    </div>
</form>
<?php 

        function getResultCategory($score) {
            if ($score >= 96) return "Mastered";
            if ($score >= 86) return "Closely Approximating Mastery";
            if ($score >= 66) return "Moving Toward Mastery";
            if ($score >= 35) return "Average";
            if ($score >= 15) return "Low";
            if ($score >= 5) return "Very Low";
            return "Absolutely No Mastery";
        }

        // Get filter values
        $year_filter = isset($_GET['year']) ? intval($_GET['year']) : $current_year;
        $grade_level_filter = isset($_GET['grade_level']) && $_GET['grade_level'] !== '' ? intval($_GET['grade_level']) : null;
        $quarter_filter = isset($_GET['quarter']) && $_GET['quarter'] !== '' ? intval($_GET['quarter']) : null;

$sql_summary = "
    SELECT 
        -- Mastered (96+)
        COUNT(CASE WHEN english >= 96 THEN 1 END) AS mastered_english,
        COUNT(CASE WHEN filipino >= 96 THEN 1 END) AS mastered_filipino,
        COUNT(CASE WHEN aralpan >= 96 THEN 1 END) AS mastered_aralpan,
        COUNT(CASE WHEN esp >= 96 THEN 1 END) AS mastered_esp,
        COUNT(CASE WHEN math >= 96 THEN 1 END) AS mastered_math,
        COUNT(CASE WHEN science >= 96 THEN 1 END) AS mastered_science,
        COUNT(CASE WHEN mapeh >= 96 THEN 1 END) AS mastered_mapeh,
        COUNT(CASE WHEN tle >= 96 THEN 1 END) AS mastered_tle,

        -- Closely Approximating Mastery (86-95)
        COUNT(CASE WHEN english BETWEEN 86 AND 95 THEN 1 END) AS cam_english,
        COUNT(CASE WHEN filipino BETWEEN 86 AND 95 THEN 1 END) AS cam_filipino,
        COUNT(CASE WHEN aralpan BETWEEN 86 AND 95 THEN 1 END) AS cam_aralpan,
        COUNT(CASE WHEN esp BETWEEN 86 AND 95 THEN 1 END) AS cam_esp,
        COUNT(CASE WHEN math BETWEEN 86 AND 95 THEN 1 END) AS cam_math,
        COUNT(CASE WHEN science BETWEEN 86 AND 95 THEN 1 END) AS cam_science,
        COUNT(CASE WHEN mapeh BETWEEN 86 AND 95 THEN 1 END) AS cam_mapeh,
        COUNT(CASE WHEN tle BETWEEN 86 AND 95 THEN 1 END) AS cam_tle,

        -- Moving Toward Mastery (66-85)
        COUNT(CASE WHEN english BETWEEN 66 AND 85 THEN 1 END) AS mtm_english,
        COUNT(CASE WHEN filipino BETWEEN 66 AND 85 THEN 1 END) AS mtm_filipino,
        COUNT(CASE WHEN aralpan BETWEEN 66 AND 85 THEN 1 END) AS mtm_aralpan,
        COUNT(CASE WHEN esp BETWEEN 66 AND 85 THEN 1 END) AS mtm_esp,
        COUNT(CASE WHEN math BETWEEN 66 AND 85 THEN 1 END) AS mtm_math,
        COUNT(CASE WHEN science BETWEEN 66 AND 85 THEN 1 END) AS mtm_science,
        COUNT(CASE WHEN mapeh BETWEEN 66 AND 85 THEN 1 END) AS mtm_mapeh,
        COUNT(CASE WHEN tle BETWEEN 66 AND 85 THEN 1 END) AS mtm_tle,

        -- Average (35-65)
        COUNT(CASE WHEN english BETWEEN 35 AND 65 THEN 1 END) AS avg_english,
        COUNT(CASE WHEN filipino BETWEEN 35 AND 65 THEN 1 END) AS avg_filipino,
        COUNT(CASE WHEN aralpan BETWEEN 35 AND 65 THEN 1 END) AS avg_aralpan,
        COUNT(CASE WHEN esp BETWEEN 35 AND 65 THEN 1 END) AS avg_esp,
        COUNT(CASE WHEN math BETWEEN 35 AND 65 THEN 1 END) AS avg_math,
        COUNT(CASE WHEN science BETWEEN 35 AND 65 THEN 1 END) AS avg_science,
        COUNT(CASE WHEN mapeh BETWEEN 35 AND 65 THEN 1 END) AS avg_mapeh,
        COUNT(CASE WHEN tle BETWEEN 35 AND 65 THEN 1 END) AS avg_tle,

        -- Low (15-34)
        COUNT(CASE WHEN english BETWEEN 15 AND 34 THEN 1 END) AS low_english,
        COUNT(CASE WHEN filipino BETWEEN 15 AND 34 THEN 1 END) AS low_filipino,
        COUNT(CASE WHEN aralpan BETWEEN 15 AND 34 THEN 1 END) AS low_aralpan,
        COUNT(CASE WHEN esp BETWEEN 15 AND 34 THEN 1 END) AS low_esp,
        COUNT(CASE WHEN math BETWEEN 15 AND 34 THEN 1 END) AS low_math,
        COUNT(CASE WHEN science BETWEEN 15 AND 34 THEN 1 END) AS low_science,
        COUNT(CASE WHEN mapeh BETWEEN 15 AND 34 THEN 1 END) AS low_mapeh,
        COUNT(CASE WHEN tle BETWEEN 15 AND 34 THEN 1 END) AS low_tle,

        -- Very Low (5-14)
        COUNT(CASE WHEN english BETWEEN 5 AND 14 THEN 1 END) AS very_low_english,
        COUNT(CASE WHEN filipino BETWEEN 5 AND 14 THEN 1 END) AS very_low_filipino,
        COUNT(CASE WHEN aralpan BETWEEN 5 AND 14 THEN 1 END) AS very_low_aralpan,
        COUNT(CASE WHEN esp BETWEEN 5 AND 14 THEN 1 END) AS very_low_esp,
        COUNT(CASE WHEN math BETWEEN 5 AND 14 THEN 1 END) AS very_low_math,
        COUNT(CASE WHEN science BETWEEN 5 AND 14 THEN 1 END) AS very_low_science,
        COUNT(CASE WHEN mapeh BETWEEN 5 AND 14 THEN 1 END) AS very_low_mapeh,
        COUNT(CASE WHEN tle BETWEEN 5 AND 14 THEN 1 END) AS very_low_tle,

        -- Absolutely No Mastery (<5)
        COUNT(CASE WHEN english < 5 THEN 1 END) AS no_mastery_english,
        COUNT(CASE WHEN filipino < 5 THEN 1 END) AS no_mastery_filipino,
        COUNT(CASE WHEN aralpan < 5 THEN 1 END) AS no_mastery_aralpan,
        COUNT(CASE WHEN esp < 5 THEN 1 END) AS no_mastery_esp,
        COUNT(CASE WHEN math < 5 THEN 1 END) AS no_mastery_math,
        COUNT(CASE WHEN science < 5 THEN 1 END) AS no_mastery_science,
        COUNT(CASE WHEN mapeh < 5 THEN 1 END) AS no_mastery_mapeh,
        COUNT(CASE WHEN tle < 5 THEN 1 END) AS no_mastery_tle

    FROM learners_score
    WHERE school_id = '$school_id'
    AND YEAR(created_at) = $year_filter";

// Apply filters
if ($grade_level_filter) $sql_summary .= " AND grade_level = $grade_level_filter";
if ($quarter_filter) $sql_summary .= " AND quarter = $quarter_filter";

// Execute query
$query_summary = mysqli_query($DB, $sql_summary);
$summary = mysqli_fetch_assoc($query_summary);

        ?>




                <table id="example2" class="table table-bordered" >
    <thead>
        <tr>
            <th>Category</th>
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
        // Function to calculate total learners per row
        function getTotal($subjects) {
            return array_sum($subjects);
        }
        ?>

        <tr>
            <td>Mastered (96+)</td>
            <?php 
            $mastered = [
                $summary['mastered_english'], $summary['mastered_filipino'], $summary['mastered_aralpan'],
                $summary['mastered_esp'], $summary['mastered_math'], $summary['mastered_science'],
                $summary['mastered_mapeh'], $summary['mastered_tle']
            ];
            ?>
            <td><?= implode('</td><td>', $mastered) ?></td>
        </tr>
        
        <tr>
            <td>Closely Approximating Mastery (86-95)</td>
            <?php 
            $cam = [
                $summary['cam_english'], $summary['cam_filipino'], $summary['cam_aralpan'],
                $summary['cam_esp'], $summary['cam_math'], $summary['cam_science'],
                $summary['cam_mapeh'], $summary['cam_tle']
            ];
            ?>
            <td><?= implode('</td><td>', $cam) ?></td>
        </tr>

        <tr>
            <td>Moving Toward Mastery (66-85)</td>
            <?php 
            $mtm = [
                $summary['mtm_english'], $summary['mtm_filipino'], $summary['mtm_aralpan'],
                $summary['mtm_esp'], $summary['mtm_math'], $summary['mtm_science'],
                $summary['mtm_mapeh'], $summary['mtm_tle']
            ];
            ?>
            <td><?= implode('</td><td>', $mtm) ?></td>
        </tr>

        <tr>
            <td>Average (35-65)</td>
            <?php 
            $avg = [
                $summary['avg_english'], $summary['avg_filipino'], $summary['avg_aralpan'],
                $summary['avg_esp'], $summary['avg_math'], $summary['avg_science'],
                $summary['avg_mapeh'], $summary['avg_tle']
            ];
            ?>
            <td><?= implode('</td><td>', $avg) ?></td>
        </tr>

        <tr>
            <td>Low (15-34)</td>
            <?php 
            $low = [
                $summary['low_english'], $summary['low_filipino'], $summary['low_aralpan'],
                $summary['low_esp'], $summary['low_math'], $summary['low_science'],
                $summary['low_mapeh'], $summary['low_tle']
            ];
            ?>
            <td><?= implode('</td><td>', $low) ?></td>
        </tr>

        <tr>
            <td>Very Low (5-14)</td>
            <?php 
            $very_low = [
                $summary['very_low_english'], $summary['very_low_filipino'], $summary['very_low_aralpan'],
                $summary['very_low_esp'], $summary['very_low_math'], $summary['very_low_science'],
                $summary['very_low_mapeh'], $summary['very_low_tle']
            ];
            ?>
            <td><?= implode('</td><td>', $very_low) ?></td>
        </tr>

        <tr>
            <td>Absolutely No Mastery (<5)</td>
            <?php 
            $no_mastery = [
                $summary['no_mastery_english'], $summary['no_mastery_filipino'], $summary['no_mastery_aralpan'],
                $summary['no_mastery_esp'], $summary['no_mastery_math'], $summary['no_mastery_science'],
                $summary['no_mastery_mapeh'], $summary['no_mastery_tle']
            ];
            ?>
            <td><?= implode('</td><td>', $no_mastery) ?></td>
        </tr>

    </tbody>
</table>







    <?php
        // Base SQL query
        $sql = "
            SELECT 
                YEAR(created_at) AS year,
                grade_level,
                quarter,
                ROUND((SUM(english) / SUM(t_english)) * 100, 2) AS english_mps,
                ROUND((SUM(filipino) / SUM(t_filipino)) * 100, 2) AS filipino_mps,
                ROUND((SUM(aralpan) / SUM(t_aralpan)) * 100, 2) AS aralpan_mps,
                ROUND((SUM(esp) / SUM(t_esp)) * 100, 2) AS esp_mps,
                ROUND((SUM(math) / SUM(t_math)) * 100, 2) AS math_mps,
                ROUND((SUM(science) / SUM(t_science)) * 100, 2) AS science_mps,
                ROUND((SUM(mapeh) / SUM(t_mapeh)) * 100, 2) AS mapeh_mps,
                ROUND((SUM(tle) / SUM(t_tle)) * 100, 2) AS tle_mps
            FROM learners_score
            WHERE t_english > 0 AND t_filipino > 0 AND t_aralpan > 0 
            AND t_esp > 0 AND t_math > 0 AND t_science > 0 
            AND t_mapeh > 0 AND t_tle > 0 AND school_id = '$school_id'
            AND YEAR(created_at) = $year_filter";

        // Apply filters if selected
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

?>

<!-- Table Display -->
<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Year</th>
            <th>Grade Level</th>
            <th>Term</th>
            <th>English </th>
            <th>Filipino </th>
            <th>Araling Panlipunan </th>
            <th>ESP </th>
            <th>Math </th>
            <th>Science </th>
            <th>MAPEH </th>
            <th>TLE </th>
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
                <td>{$row['english_mps']}%<br><small><b>" . getResultCategory($row['english_mps']) . "</b></small></td>
                <td>{$row['filipino_mps']}%<br><small><b>" . getResultCategory($row['filipino_mps']) . "</b></small></td>
                <td>{$row['aralpan_mps']}%<br><small><b>" . getResultCategory($row['aralpan_mps']) . "</b></small></td>
                <td>{$row['esp_mps']}%<br><small><b>" . getResultCategory($row['esp_mps']) . "</b></small></td>
                <td>{$row['math_mps']}%<br><small><b>" . getResultCategory($row['math_mps']) . "</b></small></td>
                <td>{$row['science_mps']}%<br><small><b>" . getResultCategory($row['science_mps']) . "</b></small></td>
                <td>{$row['mapeh_mps']}%<br><small><b>" . getResultCategory($row['mapeh_mps']) . "</b></small></td>
                <td>{$row['tle_mps']}%<br><small><b>" . getResultCategory($row['tle_mps']) . "</b></small></td>
                <td>";
                                ?>
                                     <a href="javascript:void(0);"  class="view-interventions" data-school_name="<?php echo $_SESSION['school_name']; ?>"
                                          data-english="<?php echo $row['english_mps']; ?>"
                                         data-filipino="<?php echo $row['filipino_mps']; ?>"
                                         data-aralpan="<?php echo $row['aralpan_mps']; ?>"
                                         data-esp="<?php echo $row['esp_mps']; ?>"
                                         data-math="<?php echo $row['math_mps']; ?>"
                                         data-science="<?php echo $row['science_mps']; ?>"
                                         data-mapeh="<?php echo $row['mapeh_mps']; ?>"
                                         data-tle="<?php echo $row['tle_mps']; ?>">Generate Interventions</a>
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
    <!-- /.container-fluid -->
</section>

   <!-- /.content -->
</div><div id="interventionsModal" class="modal fade" tabindex="-1" aria-labelledby="interventionsModalLabel" aria-hidden="true">
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
<script>// Function to close the modal using Bootstrap's method
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
            url: '../admin/generate_interventions.php',
            method: 'GET',
            data: {
                type: 'mps',
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