<?php
    include('includes/header.php');
    include('includes/topbar.php');
    include('includes/sidebar.php');
    include('includes/modals.php');

    
    if(isset($_GET['filtration'])){
        
                $district = isset($_GET['district']) ? mysqli_real_escape_string($DB, $_GET['district']) : null;
                $grade_level = isset($_GET['grade_level']) ? mysqli_real_escape_string($DB, $_GET['grade_level']) : null;
                $year_level = isset($_GET['year_level']) ? mysqli_real_escape_string($DB, $_GET['year_level']) : null;
            
                $teacherConditions = [];
                $learnerConditions = [];
                $schoolConditions = [];
            
                // Add conditions dynamically
                if (!empty($district) && $district != '') {
                    $teacherConditions[] = "b.district = '$district'";
                    $learnerConditions[] = "b.district = '$district'";
                    $schoolConditions[] = "district = '$district'";
                }
                if (!empty($grade_level) && $grade_level != '') {
                    $learnerConditions[] = "a.grade_level LIKE '%$grade_level%'";
                }
            
                // Build WHERE clauses dynamically
                $teacherWhereClause = !empty($teacherConditions) ? "WHERE " . implode(" AND ", $teacherConditions) : "";
                $learnerWhereClause = !empty($learnerConditions) ? "WHERE " . implode(" AND ", $learnerConditions) : "";
                $schoolWhereClause = !empty($schoolConditions) ? "WHERE " . implode(" AND ", $schoolConditions) : "";
            
                $teachers_count = 0;
                $learners_count = 0;
                $schools_count = 0;
            
                $query_teachers = "SELECT COUNT(*) AS total FROM teachers_profiling AS a 
                                   INNER JOIN schools AS b ON a.school_id = b.school_id 
                                   $teacherWhereClause";
            
                $residencecount = mysqli_query($DB, $query_teachers);
                $countRow = mysqli_fetch_assoc($residencecount);
                $teachers_count = (int) ($countRow['total'] ?? 0);
            
                $query_learners = "SELECT COUNT(*) AS total FROM students AS a 
                                   INNER JOIN schools AS b ON a.school_id = b.school_id 
                                   $learnerWhereClause";
            
                $residencecount = mysqli_query($DB, $query_learners);
                $countRow = mysqli_fetch_assoc($residencecount);
                $learners_count = (int) ($countRow['total'] ?? 0);
            
                $query_schools = "SELECT COUNT(*) AS total FROM schools $schoolWhereClause";
                $residencecount = mysqli_query($DB, $query_schools);
                $countRow = mysqli_fetch_assoc($residencecount);
                $schools_count = (int) ($countRow['total'] ?? 0);
            
                // ✅ Query to count different categories in the students table
                $query_students = "
                    SELECT 
                        SUM(grade_level = 'Kinder') AS Kinder,
                        SUM(grade_level = 'Grade 1') AS grade1,
                        SUM(grade_level = 'Grade 2') AS grade2,
                        SUM(grade_level = 'Grade 3') AS grade3,
                        SUM(grade_level = 'Grade 4') AS grade4,
                        SUM(grade_level = 'Grade 5') AS grade5,
                        SUM(grade_level = 'Grade 6') AS grade6,
                        SUM(grade_level = 'Grade 7') AS grade7,
                        SUM(grade_level = 'Grade 8') AS grade8,
                        SUM(grade_level = 'Grade 9') AS grade9,
                        SUM(grade_level = 'Grade 10') AS grade10,
                        SUM(grade_level = 'Grade 11') AS grade11,
                        SUM(grade_level = 'Grade 12') AS grade12 
                    FROM students AS a 
                    INNER JOIN schools AS b ON a.school_id = b.school_id 
                        $learnerWhereClause";
            
                $result_students = mysqli_query($DB, $query_students);
            
                $grade_counts = [
                    'Kinder' => 0, 'Grade 1' => 0, 'Grade 2' => 0, 'Grade 3' => 0, 'Grade 4' => 0,
                    'Grade 5' => 0, 'Grade 6' => 0, 'Grade 7' => 0, 'Grade 8' => 0,
                    'Grade 9' => 0, 'Grade 10' => 0,
                    'Grade 11' => 0, 'Grade 12' => 0
                ];
            
                if ($result_students && mysqli_num_rows($result_students) > 0) {
                    $data_students = mysqli_fetch_assoc($result_students);
                    
                    // ✅ Fix: Ensure Kinder is always set
                    $grade_counts['Kinder'] = isset($data_students['Kinder']) && $data_students['Kinder'] !== NULL ? $data_students['Kinder'] : 0;
                    $grade_counts['Grade 1'] = isset($data_students['grade1']) ? $data_students['grade1'] : 0;
                    $grade_counts['Grade 2'] = isset($data_students['grade2']) ? $data_students['grade2'] : 0;
                    $grade_counts['Grade 3'] = isset($data_students['grade3']) ? $data_students['grade3'] : 0;
                    $grade_counts['Grade 4'] = isset($data_students['grade4']) ? $data_students['grade4'] : 0;
                    $grade_counts['Grade 5'] = isset($data_students['grade5']) ? $data_students['grade5'] : 0;
                    $grade_counts['Grade 6'] = isset($data_students['grade6']) ? $data_students['grade6'] : 0;
                    $grade_counts['Grade 7'] = isset($data_students['grade7']) ? $data_students['grade7'] : 0;
                    $grade_counts['Grade 8'] = isset($data_students['grade8']) ? $data_students['grade8'] : 0;
                    $grade_counts['Grade 9'] = isset($data_students['grade9']) ? $data_students['grade9'] : 0;
                    $grade_counts['Grade 10'] = isset($data_students['grade10']) ? $data_students['grade10'] : 0;
                    $grade_counts['Grade 11'] = isset($data_students['grade11']) ? $data_students['grade11'] : 0;
                    $grade_counts['Grade 12'] = isset($data_students['grade12']) ? $data_students['grade12'] : 0;
                }
        
    }else{
        
        $teachers_count = 0;
        $learners_count = 0;
        $schools_count = 0;
        $residencecount = mysqli_query($DB, "SELECT COUNT(*) AS total FROM teachers_profiling");
        $countRow = mysqli_fetch_assoc($residencecount);
        $teachers_count = (int) ($countRow['total'] ?? 0);

        $residencecount = mysqli_query($DB, "SELECT COUNT(*) AS total FROM students");
        $countRow = mysqli_fetch_assoc($residencecount);
        $learners_count = (int) ($countRow['total'] ?? 0);

        $residencecount = mysqli_query($DB, "SELECT COUNT(*) AS total FROM schools");
        $countRow = mysqli_fetch_assoc($residencecount);
        $schools_count = (int) ($countRow['total'] ?? 0);
        
        // Get total number of schools
        $total_schools_query = "SELECT COUNT(DISTINCT school_id) AS total_schools FROM schools";
        $total_schools_result = mysqli_query($DB, $total_schools_query);
        $total_schools_row = mysqli_fetch_assoc($total_schools_result);
        $total_schools = $total_schools_row['total_schools'];
        
        // Initialize quarters (1 to 4) with 0 submitted
        $chartData = [
            'First Term' => ['submitted' => 0, 'not_submitted' => $total_schools],
            'Second Term' => ['submitted' => 0, 'not_submitted' => $total_schools],
            'Third Term' => ['submitted' => 0, 'not_submitted' => $total_schools],
            'Fourth Term' => ['submitted' => 0, 'not_submitted' => $total_schools],
        ];
        
        // Get the number of schools that submitted records per term
        $query = "SELECT 
                    quarter, 
                    COUNT(DISTINCT school_id) AS submitted_schools
                  FROM learners_grade
                  GROUP BY quarter
                  ORDER BY quarter";
        
        $result = mysqli_query($DB, $query);
        
        while ($row = mysqli_fetch_assoc($result)) {
        
            if($row['quarter'] == '1'){
                $quarter = "First Term";
            }
            if($row['quarter'] == '2'){
                $quarter = "Second Term";
            }
            if($row['quarter'] == '3'){
                $quarter = "Third Term";
            }
            if($row['quarter'] == '4'){
                $quarter = "Fourth Term";
            }
            $submitted = $row['submitted_schools'];
            $not_submitted = $total_schools - $submitted; // Calculate not submitted
        
            $chartData[$quarter] = [
                'submitted' => $submitted,
                'not_submitted' => $not_submitted
            ];
        }
              // Query to count schools based on different categories
              $query = "
                  SELECT 
                      SUM(accessibility = 'Highly Accessible') AS highly_accessible,
                      SUM(accessibility = 'Moderately Accessible') AS moderately_accessible,
                      SUM(accessibility = 'Last Mile Schools') AS last_mile_schools,
                      SUM(facilities = 'Fully Equipped') AS fully_equipped,
                      SUM(facilities = 'Moderately Equipped') AS moderately_equipped,
                      SUM(facilities = 'Minimally Equipped') AS minimally_equipped,
                      SUM(internetconnectivity = 'High Speed Internet') AS high_speed,
                      SUM(internetconnectivity = 'Average Speed Internet') AS average_speed,
                      SUM(internetconnectivity = 'No Internet') AS no_internet
                  FROM schools";

              $result = mysqli_query($DB, $query);
              $data = mysqli_fetch_assoc($result);

              // Assign variables
              $highly_accessible = $data['highly_accessible'];
              $moderately_accessible = $data['moderately_accessible'];
              $last_mile_schools = $data['last_mile_schools'];

              $fully_equipped = $data['fully_equipped'];
              $moderately_equipped = $data['moderately_equipped'];
              $minimally_equipped = $data['minimally_equipped'];

              $high_speed = $data['high_speed'];
              $average_speed = $data['average_speed'];
              $no_internet = $data['no_internet'];
              
        // Query to count different categories in the students table
        $query_students = "
            SELECT 
                -- Count Male and Female students
                SUM(sex = 'Male') AS male_count,
                SUM(sex = 'Female') AS female_count,
        
                -- Count economic status
                SUM(economic_status = 'Low') AS low_econ,
                SUM(economic_status = 'Middle') AS middle_econ,
                SUM(economic_status = 'High') AS high_econ,
        
                -- Count grade levels from Grade 1 to Grade 10
                SUM(grade_level = 'Kinder') AS Kinder,
                SUM(grade_level = 'Grade 1') AS grade1,
                SUM(grade_level = 'Grade 2') AS grade2,
                SUM(grade_level = 'Grade 3') AS grade3,
                SUM(grade_level = 'Grade 4') AS grade4,
                SUM(grade_level = 'Grade 5') AS grade5,
                SUM(grade_level = 'Grade 6') AS grade6,
                SUM(grade_level = 'Grade 7') AS grade7,
                SUM(grade_level = 'Grade 8') AS grade8,
                SUM(grade_level = 'Grade 9') AS grade9,
                SUM(grade_level = 'Grade 10') AS grade10,
                SUM(grade_level = 'Grade 11') AS grade11,
                SUM(grade_level = 'Grade 12') AS grade12,
        
                -- Count quarterly attendance
                SUM(quarterly_attendance = 'Excellent') AS excellent_attendance,
                SUM(quarterly_attendance = 'Satisfactory') AS satisfactory_attendance,
                SUM(quarterly_attendance = 'Poor') AS poor_attendance,
        
                -- Count extra-curricular activities
                SUM(extra_curricular = 'Athlete') AS athlete_count,
                SUM(extra_curricular = 'Academic Contest Participant') AS academic_contest,
                SUM(extra_curricular = 'None') AS no_extracurricular,
        
                -- Count settlement type
                SUM(settlement = 'Urban') AS urban_count,
                SUM(settlement = 'Rural') AS rural_count,
                SUM(settlement = 'Informal') AS informal_count,
        
                -- Count physical/mental status
                SUM(physical_mental_status = 'Excellent') AS excellent_health,
                SUM(physical_mental_status = 'Moderate') AS moderate_health,
                SUM(physical_mental_status = 'Poor') AS poor_health,
        
                -- Count Yes and No under feeding program receipt
                SUM(feeding_prog_receipt = 'Yes') AS feeding_yes,
                SUM(feeding_prog_receipt = 'No') AS feeding_no
        
            FROM students";
        
        $result_students = mysqli_query($DB, $query_students);
        $data_students = mysqli_fetch_assoc($result_students);
        
        // Assign variables
        $male_count = $data_students['male_count'];
        $female_count = $data_students['female_count'];
        
        $low_econ = $data_students['low_econ'];
        $middle_econ = $data_students['middle_econ'];
        $high_econ = $data_students['high_econ'];
        
        $grade_counts = [
            'Kinder' => $data_students['Kinder'], 
            'Grade 1' => $data_students['grade1'],
            'Grade 2' => $data_students['grade2'],
            'Grade 3' => $data_students['grade3'],
            'Grade 4' => $data_students['grade4'],
            'Grade 5' => $data_students['grade5'],
            'Grade 6' => $data_students['grade6'],
            'Grade 7' => $data_students['grade7'],
            'Grade 8' => $data_students['grade8'],
            'Grade 9' => $data_students['grade9'],
            'Grade 10' => $data_students['grade10'],
            'Grade 11' => $data_students['grade11'],
            'Grade 12' => $data_students['grade12']
        ];
        
        $excellent_attendance = $data_students['excellent_attendance'];
        $satisfactory_attendance = $data_students['satisfactory_attendance'];
        $poor_attendance = $data_students['poor_attendance'];
        
        $athlete_count = $data_students['athlete_count'];
        $academic_contest = $data_students['academic_contest'];
        $no_extracurricular = $data_students['no_extracurricular'];
        
        $urban_count = $data_students['urban_count'];
        $rural_count = $data_students['rural_count'];
        $informal_count = $data_students['informal_count'];
        
        $excellent_health = $data_students['excellent_health'];
        $moderate_health = $data_students['moderate_health'];
        $poor_health = $data_students['poor_health'];
        
        $feeding_yes = $data_students['feeding_yes'];
        $feeding_no = $data_students['feeding_no'];
        
        // Query to count teachers based on education, gender, and major
        $query_teachers = "
            SELECT 
                SUM(education = 'Master') AS master_count,
                SUM(education = 'Bachelor') AS bachelor_count,
                SUM(education = 'Doctorate') AS doctorate_count,
        
                SUM(sex = 'Male') AS male_teachers,
                SUM(sex = 'Female') AS female_teachers
            FROM teachers_profiling";
        
        $result_teachers = mysqli_query($DB, $query_teachers);
        $data_teachers = mysqli_fetch_assoc($result_teachers);
        
        // Query to count teachers per major dynamically
        $query_majors = "SELECT major, COUNT(*) AS major_count FROM teachers_profiling GROUP BY major";
        $result_majors = mysqli_query($DB, $query_majors);
        
        $major_counts = [];
        while ($row = mysqli_fetch_assoc($result_majors)) {
            $major_counts[$row['major']] = $row['major_count'];
        }
    }
?>
<style>
    .bg-blue{
        background-color:#d0e4a0 !important;
        color:black !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 accent-blue">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
<?php
$selectedDistrict = isset($_GET['district']) && $_GET['district'] !== '' ? $_GET['district'] : 'All Districts';
$selectedYear = isset($_GET['year']) && $_GET['year'] !== '' ? $_GET['year'] : 'All Years';
$selectedGrade = isset($_GET['grade_level']) && $_GET['grade_level'] !== '' ? 'Grade ' . $_GET['grade_level'] : 'All Grades';

if (!empty($_GET['district']) || !empty($_GET['year']) || !empty($_GET['grade_level'])) {
?>
    <div class="dashboard-filter-summary">
        
        <div class="dashboard-filter-summary-item">
            <h5>District</h5>
            <p><?php echo htmlspecialchars($selectedDistrict, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="dashboard-filter-summary-item">
            <h5>Year</h5>
            <p><?php echo htmlspecialchars($selectedYear, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>

        <div class="dashboard-filter-summary-item">
            <h5>Grade Level</h5>
            <p><?php echo htmlspecialchars($selectedGrade, ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>
    <br>
<?php } ?>



            
               <form method="GET" action="" class="dashboard-filters">
                  <div class="row">
                    <div class="col-md-2">
                        <label for="district">Select District:</label>
                        <select class="form-control" name="district">
                            <option value="">All Districts</option>
                                <?php
                                $districts = ["Bangued", "Bucay", "La Paz", "Lagangilang", "Luba", "Dolores", "Pidigan", "San Juan", "Pilar", "Sallapadan"];
                                foreach ($districts as $district) {
                                    $selected = (isset($_GET['district']) && $_GET['district'] == $district) ? 'selected' : '';
                                    echo "<option value='$district' $selected>$district</option>";
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
                     <div class="col-md-2">
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
                     <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" id="filtration" name="filtration" class="btn btn-primary">Filter</button>
                        <a href="dashboard.php" class="btn btn-secondary ml-2">Reset</a>
                     </div>
                  </div>
               </form>
<hr>
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3 class="text-black"><?php echo $teachers_count; ?></h3>

                            <p class="text-black">Teachers</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" style="color:black;"></i>
                            
                        </div>
                        <a href="manage_teacher.php" class="small-box-footer" style="color:gray !important;">View Details <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3 class="text-black"><?php echo $learners_count; ?></h3>

                            <p class="text-black">Learners</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" style="color:black;"></i>
                            
                        </div>
                        <a href="manage_student.php" class="small-box-footer" style="color:gray !important;">View Details <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-blue">
                        <div class="inner">
                            <h3 class="text-black"><?php echo $schools_count; ?></h3>

                            <p class="text-black">Schools</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-building" style="color:black;"></i>
                            
                        </div>
                        <a href="manage_school.php" class="small-box-footer" style="color:gray !important;">View Details <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
            <style>
                /* Custom column for different screen sizes */
.col-1-5 {
    flex: 0 0 calc(12.5%); /* 1.5 / 12 = 12.5% */
    max-width: calc(12.5%);
}

/* Tablet (Bootstrap md breakpoint) */
@media (max-width: 992px) {
    .col-md-1-5 {
        flex: 0 0 calc(20%); /* Adjust to 2 columns on tablets */
        max-width: calc(20%);
    }
}

/* Mobile (Bootstrap sm breakpoint) */
@media (max-width: 768px) {
    .col-sm-1-5 {
        flex: 0 0 calc(33.33%); /* Adjust to 3 columns on mobile */
        max-width: calc(33.33%);
    }
}

/* Extra Small Screens (Bootstrap xs breakpoint) */
@media (max-width: 576px) {
    .col-xs-1-5 {
        flex: 0 0 50%; /* Adjust to 2 columns on extra small screens */
        max-width: 50%;
    }
}
.col-lg-1-7 {
    flex: 0 0 calc(100% / 7); 
    max-width: calc(100% / 7);
}

            </style>
<div class="row d-flex flex-wrap dashboard-grade-grid">
    <?php 
    $counter = 0;
    foreach ($grade_counts as $grade => $count) { 
        $counter++; 
        // Apply different widths for the first 7 items and the next 6
        $col_class = ($counter <= 7) ? 'col-lg-1-7' : 'col-lg-2'; 
    ?>
    
    <div class="<?php echo $col_class; ?> col-md-2 col-sm-4 col-6">
        <!-- small box -->
        <div class="small-box bg-blue" <?php if($count == 0){ ?> style='background-color:#d9d9d9 !important;' <?php } ?>>
            <div class="inner">
                <h3 class="text-black"><?php echo $count; ?></h3>
                <p class="text-black"><?php echo $grade; ?></p>
            </div>
            <div class="icon" style="font-size:4vh !important;">
                <i class="fa fa-users" style="color:black;font-size:4vh !important; "></i>
            </div>
        </div>
    </div>

    <?php } ?>
</div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>

             

               <br>
<?php
$selected_grade = isset($_GET['grade_level']) && $_GET['grade_level'] !== "" ? " (Grade " . $_GET['grade_level'] . ")" : "";
?>

<div class="row dashboard-chart-row"> 
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="dashboard-chart-card">
            <h3><b>Mean Percentage Score Trends<?php echo $selected_grade; ?></b></h3>
            <canvas id="trendChart"></canvas>
        </div>
    </div>
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="dashboard-chart-card">
            <h3><b>Level of Proficiency Trends<?php echo $selected_grade; ?></b></h3>
            <canvas id="quarterlyChart"></canvas>
        </div>
    </div>
</div>

                <?php
                                $year_filter = isset($_GET['year']) ? $_GET['year'] : date("Y"); // Get selected year or current year

                                                  $grade_level_filter = isset($_GET['grade_level']) && $_GET['grade_level'] !== '' ? intval($_GET['grade_level']) : null;
                                // Fetch distinct districts
                                $district_query = mysqli_query($DB, "SELECT DISTINCT district FROM schools ORDER BY district ASC");
                                $districts = [];
                                while ($row = mysqli_fetch_assoc($district_query)) {
                                    $districts[] = $row['district'];
                                }

                                // Set default district (first in the list)
                                $selected_district = isset($_GET['district']) ? $_GET['district'] : (count($districts) > 0 ? $districts[0] : "");

                                // Fetch available years in the database
                                $year_query = mysqli_query($DB, "SELECT DISTINCT YEAR(created_at) AS year FROM learners_score ORDER BY year DESC");
                                $years = [];
                                while ($row = mysqli_fetch_assoc($year_query)) {
                                    $years[] = $row['year'];
                                }

                                  $sql = "
                                        SELECT 
                                            s.school_id,
                                            s.district,
                                            YEAR(l.created_at) AS year,
                                            l.grade_level,
                                            l.quarter,
                                            ROUND((SUM(l.english) / SUM(l.t_english)) * 100, 2) AS english_mps,
                                            ROUND((SUM(l.filipino) / SUM(l.t_filipino)) * 100, 2) AS filipino_mps,
                                            ROUND((SUM(l.aralpan) / SUM(l.t_aralpan)) * 100, 2) AS aralpan_mps,
                                            ROUND((SUM(l.esp) / SUM(l.t_esp)) * 100, 2) AS esp_mps,
                                            ROUND((SUM(l.math) / SUM(l.t_math)) * 100, 2) AS math_mps,
                                            ROUND((SUM(l.science) / SUM(l.t_science)) * 100, 2) AS science_mps,
                                            ROUND((SUM(l.mapeh) / SUM(l.t_mapeh)) * 100, 2) AS mapeh_mps,
                                            ROUND((SUM(l.tle) / SUM(l.t_tle)) * 100, 2) AS tle_mps
                                        FROM learners_score l
                                        JOIN schools s ON l.school_id = s.school_id
                                        WHERE l.t_english > 0 AND l.t_filipino > 0 AND l.t_aralpan > 0 
                                            AND l.t_esp > 0 AND l.t_math > 0 AND l.t_science > 0 
                                            AND l.t_mapeh > 0 AND l.t_tle > 0
                                            AND YEAR(l.created_at) = $year_filter";

                                    // Apply Filters
                                    if (!empty($_GET['district'])) {
                                        $district = mysqli_real_escape_string($DB, $_GET['district']);
                                        $sql .= " AND s.district = '$district'";
                                    }
                                    if ($grade_level_filter) {
                                        $sql .= " AND l.grade_level = $grade_level_filter";
                                    }

                                    // Group and order by district
                                    $sql .= " GROUP BY s.district, year, grade_level, quarter 
                                              ORDER BY s.district, year DESC, grade_level, quarter";

                $query = mysqli_query($DB, $sql);
                $data = [];

                while ($row = mysqli_fetch_assoc($query)) {
                    $quarter = "Q" . $row['quarter'];
                    $data[$quarter]['english'] = $row['english_mps'];
                    $data[$quarter]['filipino'] = $row['filipino_mps'];
                    $data[$quarter]['aralpan'] = $row['aralpan_mps'];
                    $data[$quarter]['esp'] = $row['esp_mps'];
                    $data[$quarter]['math'] = $row['math_mps'];
                    $data[$quarter]['science'] = $row['science_mps'];
                    $data[$quarter]['mapeh'] = $row['mapeh_mps'];
                    $data[$quarter]['tle'] = $row['tle_mps'];
                }

                $jsonData = json_encode($data);
                ?>

                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>

                <script>
                    var ctx = document.getElementById("trendChart").getContext("2d");

                    var chartData = <?php echo $jsonData; ?>;
                    var terms = ["T1", "T2", "T3"];
                    var quarters = ["Q1", "Q2", "Q3"];
                    var subjects = ["english", "filipino", "aralpan", "esp", "math", "science", "mapeh", "tle"];

                    var datasets = subjects.map((subject, index) => ({
                        label: subject.charAt(0).toUpperCase() + subject.slice(1),
                        data: quarters.map(quarter => chartData[quarter] ? chartData[quarter][subject] : 0),
                        borderColor: `hsl(${index * 45}, 70%, 50%)`,
                        fill: false,
                        tension: 0.3
                    }));

                    var trendChart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: terms,
                            datasets: datasets
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: true }
                            },
                            scales: {
                                x: { title: { display: true, text: "Term" } },
                                y: { title: { display: true, text: "MPS (%)" }, beginAtZero: true}
                            }
                        }
                    });
                </script>


               

            <?php
                // Base SQL query
                $sql = "
                    SELECT 
                    district,
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


                    if (!empty($_GET['district'])) {
                        $district = mysqli_real_escape_string($DB, $_GET['district']);
                        $sql .= " AND district = '$district'";
                    }
                     // Group and order results
                     $sql .= " GROUP BY district, year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
                     
                     
                // Execute query
                $query = mysqli_query($DB, $sql);

                if (!$query) {
                    die("SQL Error: " . mysqli_error($DB)); // Debugging: Show error if query fails
                }
            ?>
               <br>

                <script>
                     document.addEventListener("DOMContentLoaded", function () {
                        let terms = ["T1", "T2", "T3"];
                        let subjectsg1 = ["english", "filipino", "aralpan", "esp", "math", "science", "mapeh", "tle"];

                        // Colors for subjects
                        let subjectColors = {
                            "english": "rgba(255, 99, 132, 1)",
                            "filipino": "rgba(54, 162, 235, 1)",
                            "aralpan": "rgba(255, 206, 86, 1)",
                            "esp": "rgba(75, 192, 192, 1)",
                            "math": "rgba(153, 102, 255, 1)",
                            "science": "rgba(255, 159, 64, 1)",
                            "mapeh": "rgba(201, 203, 207, 1)",
                            "tle": "rgba(100, 200, 150, 1)"
                        };

                        let dataset = {};

                        <?php
                        // Prepare PHP data for JavaScript
                        $chartDatag1 = [];
                        while ($row = mysqli_fetch_assoc($query)) {
                            $chartDatag1[] = [
                                'quarter' => $row['quarter'],
                                'avg_english' => $row['avg_english'],
                                'avg_filipino' => $row['avg_filipino'],
                                'avg_aralpan' => $row['avg_aralpan'],
                                'avg_esp' => $row['avg_esp'],
                                'avg_math' => $row['avg_math'],
                                'avg_science' => $row['avg_science'],
                                'avg_mapeh' => $row['avg_mapeh'],
                                'avg_tle' => $row['avg_tle']
                            ];
                        }
                        ?>

                        let chartDatag1 = <?php echo json_encode($chartDatag1); ?>;

                        // Initialize dataset for each subject (default all quarters to 0)
                        subjectsg1.forEach(subject => {
                            dataset[subject] = [0, 0, 0];
                        });

                        chartDatag1.forEach(row => {
                            let quarterIndex = row.quarter - 1;

                            subjectsg1.forEach(subject => {
                                if (quarterIndex >= 0 && quarterIndex < dataset[subject].length) {
                                    dataset[subject][quarterIndex] = row["avg_" + subject] ? row["avg_" + subject] : 0;
                                }
                            });
                        });

                        let dataSetsFormattedb1 = subjectsg1.map(subject => ({
                            label: subject.toUpperCase(),
                            borderColor: subjectColors[subject],
                            backgroundColor: subjectColors[subject],

                            fill: false,
                            data: dataset[subject]
                        }));
                        let ctx2 = document.getElementById("quarterlyChart").getContext("2d");
                        
                        var GChart = new Chart(ctx2, {
                            type: "line",
                            data: {
                                labels: terms,
                                datasets: dataSetsFormattedb1
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { display: true }
                                },
                                scales: {
                                    xAxes: [{ scaleLabel: { display: true, labelString: "Term" } }],
                                    yAxes: [{ scaleLabel: { display: true, labelString: "AVG Grades (%)" } }]
                                }

                            }
                        });
                    });

                </script>

            



            <?php
                // Base SQL query2
                $sqlgb = "
                    SELECT 
                    district,
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
                        ROUND(AVG(i), 2) AS avg_i
                    FROM learners_grade_shs
                    WHERE 
                     created_at IS NOT NULL
                    AND YEAR(created_at) = $year_filter";

                // Apply filters
                if ($grade_level_filter) {
                    $sqlgb .= " AND grade_level = '11'";
                }


                    if (!empty($_GET['district'])) {
                        $district = mysqli_real_escape_string($DB, $_GET['district']);
                        $sqlgb .= " AND district = '$district'";
                    }
                     // Group and order results
                     $sqlgb .= " GROUP BY district, year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
                     
                     
                // Execute query2
                $query2 = mysqli_query($DB, $sqlgb);

                if (!$query2) {
                    die("SQL Error: " . mysqli_error($DB)); // Debugging: Show error if query2 fails
                }
            ?>
               <br>
               <div class="row dashboard-chart-row">
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="dashboard-chart-card">
                        <h3><b>Level of Proficiency Trends ( Grade 11 )</b></h3>
                        <canvas id="quarterlyChart2"></canvas>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="dashboard-chart-card">
                        <h3><b>Level of Proficiency Trends ( Grade 12 )</b></h3>
                        <canvas id="quarterlyChart3"></canvas>
                    </div>
                </div>
               </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let terms = ["T1", "T2", "T3"];
                    let subjects = ["a", "b", "c", "d", "e", "f", "g", "h", "i"];
                
                    // Colors for subjects
                    let subjectColors = {
                        "a": "rgba(255, 99, 132, 1)",
                        "b": "rgba(54, 162, 235, 1)",
                        "c": "rgba(255, 206, 86, 1)",
                        "d": "rgba(75, 192, 192, 1)",
                        "e": "rgba(153, 102, 255, 1)",
                        "f": "rgba(255, 159, 64, 1)",
                        "g": "rgba(201, 203, 207, 1)",
                        "h": "rgba(100, 200, 150, 1)",
                        "i": "rgba(100, 200, 122, 1)"
                    };
                
                    let dataset = {};
                
                    <?php
                    // Prepare PHP data for JavaScript
                    $chartData = [];
                    while ($row = mysqli_fetch_assoc($query2)) {
                        $chartData[] = [
                            'quarter' => (int) $row['quarter'],
                            'avg_a' => $row['avg_a'],
                            'avg_b' => $row['avg_b'],
                            'avg_c' => $row['avg_c'],
                            'avg_d' => $row['avg_d'],
                            'avg_e' => $row['avg_e'],
                            'avg_f' => $row['avg_f'],
                            'avg_g' => $row['avg_g'],
                            'avg_h' => $row['avg_h'],
                            'avg_i' => $row['avg_i']
                        ];
                    }
                    ?>
                
                    let chartData = <?php echo json_encode($chartData); ?>;
                
                    subjects.forEach(subject => {
                        dataset[subject] = [0, 0, 0];
                    });
                
                    chartData.forEach(row => {
                        let quarterIndex = row.quarter - 1;
                
                        subjects.forEach(subject => {
                            if (quarterIndex >= 0 && quarterIndex < dataset[subject].length) {
                                dataset[subject][quarterIndex] = row["avg_" + subject] ? row["avg_" + subject] : 0;
                            }
                        });
                    });
                
                    let formattedDatasets = subjects.map(subject => ({
                        label: subject.toUpperCase(),
                        borderColor: subjectColors[subject],
                        backgroundColor: subjectColors[subject],
                        fill: false,
                        data: dataset[subject]
                    }));
                
                    let ctx = document.getElementById("quarterlyChart2").getContext("2d");
                
                    var GChart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: terms,
                            datasets: formattedDatasets
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: true }
                            },
                            scales: {
                                x: { title: { display: true, text: "Terms" } },
                                y: { title: { display: true, text: "AVG Grades (%)" } }
                            }
                        }
                    });
                });

            </script>





            <?php
            // Base SQL Query
            $sqlgb23 = "
                SELECT 
                    district,
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
                WHERE YEAR(created_at) = $year_filter";
            
            // Apply district filter if selected
            if (!empty($district_filter)) {
                $sqlgb23 .= " AND district = '" . mysqli_real_escape_string($DB, $district_filter) . "'";
            }
            
            // Filter only Grade 12
            $sqlgb23 .= " AND grade_level = '12'";
            
            // Grouping and ordering
            $sqlgb23 .= " GROUP BY district, year, grade_level, quarter ORDER BY year DESC, grade_level, quarter";
            
            // Execute query
            $query2 = mysqli_query($DB, $sqlgb23);
            if (!$query2) {
                die("SQL Error: " . mysqli_error($DB)); // Debugging error
            }
            
            // Fetch data into an array for JavaScript
            $chartData2 = [];
            while ($row = mysqli_fetch_assoc($query2)) {
                $chartData2[] = [
                    'quarter' => (int) $row['quarter'],
                    'avg_a' => $row['avg_a'] ?? 0,
                    'avg_b' => $row['avg_b'] ?? 0,
                    'avg_c' => $row['avg_c'] ?? 0,
                    'avg_d' => $row['avg_d'] ?? 0,
                    'avg_e' => $row['avg_e'] ?? 0,
                    'avg_f' => $row['avg_f'] ?? 0,
                    'avg_g' => $row['avg_g'] ?? 0,
                    'avg_h' => $row['avg_h'] ?? 0,
                    'avg_i' => $row['avg_i'] ?? 0,
                    'avg_j' => $row['avg_j'] ?? 0
                ];
            }

            ?>

            <!-- Include Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <!-- Chart Container -->
            <canvas id="quarterlyChart3"></canvas>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    let terms = ["T1", "T2", "T3"];
                    let subjects = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j"];
                
                    let subjectColors = {
                        "a": "rgba(255, 99, 132, 1)",
                        "b": "rgba(54, 162, 235, 1)",
                        "c": "rgba(255, 206, 86, 1)",
                        "d": "rgba(75, 192, 192, 1)",
                        "e": "rgba(153, 102, 255, 1)",
                        "f": "rgba(255, 159, 64, 1)",
                        "g": "rgba(201, 203, 207, 1)",
                        "h": "rgba(100, 200, 150, 1)",
                        "i": "rgba(100, 200, 122, 1)",
                        "j": "rgba(100, 200, 133, 1)"
                    };
                
                    // Get data from PHP
                    let chartData = <?php echo json_encode($chartData2); ?>;
                    console.log("PHP Data:", chartData); // Debugging
                
                    let dataset = {};
                    subjects.forEach(subject => {
                        dataset[subject] = [0, 0, 0];
                    });
                
                    chartData.forEach(row => {
                        let quarterIndex = row.quarter - 1;
                
                        subjects.forEach(subject => {
                            if (quarterIndex >= 0 && quarterIndex < dataset[subject].length) {
                                dataset[subject][quarterIndex] = row["avg_" + subject] ? row["avg_" + subject] : 0;
                            }
                        });
                    });
                
                    let formattedDatasets = subjects.map(subject => ({
                        label: subject.toUpperCase(),
                        borderColor: subjectColors[subject],
                        backgroundColor: subjectColors[subject],
                        fill: false,
                        data: dataset[subject]
                    }));
                
                    let ctx = document.getElementById("quarterlyChart3").getContext("2d");
                
                    new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: terms,
                            datasets: formattedDatasets
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: { display: true }
                            },
                            scales: {
                                x: { title: { display: true, text: "Term" } },
                                y: { title: { display: true, text: "AVG Grades (%)" } }
                            }
                        }
                    });
                });

            </script>
        </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->
</div>
    <script type="text/javascript">
        // Reload the page when user attempts to navigate back
        window.onbeforeunload = function () {
            location.reload(true);
        };
    </script>
<?php
include('includes/footer.php');
?>