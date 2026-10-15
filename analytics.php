<?php
	include('includes/database_connection.php');
	$systemconfig = mysqli_query($DB, "Select * From settings WHERE id='1'");
	if (mysqli_num_rows($systemconfig) > 0) 
	{ 
	    while ($row = mysqli_fetch_assoc($systemconfig)) 
	    {
	        $SYS_logo = $row['SYS_logo'];
	        $SYS_name = $row['SYS_name'];
	        $SYS_background = $row['SYS_background'];
	        $AB_title = $row['AB_title'];
	        $AB_headerpicture = $row['AB_headerpicture'];
	        $AB_officephoto = $row['AB_officephoto'];
	        $NUP_title = $row['NUP_title'];
	        $NUP_headerpicture = $row['NUP_headerpicture'];
	        $CP_title = $row['CP_title'];
	        $CP_headerpicture = $row['CP_headerpicture'];
	        $CP_email = $row['CP_email'];
	        $CP_contact = $row['CP_contact'];
	    }
	}
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Analytics - <?php echo htmlspecialchars($SYS_name ?? 'CID Learning Analytics', ENT_QUOTES, 'UTF-8'); ?></title>
		<link rel="stylesheet" href="style/css/bootstrap.min.css">
		<script defer src="style/js/bootstrap.bundle.js"></script>
		<!-- Icon Font Stylesheet -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
		<link rel="icon" type="image/jpg" href="images/<?php echo $SYS_logo; ?>">
		<link rel="stylesheet" href="style/myStyle.css">
		<link rel="stylesheet" href="style/page-refresh.css?v=2">
		<link rel="stylesheet" href="style/app-polish.css?v=6">
	</head>
	<?php
		include 'includes/modals.php';
		?>
	<body class="analytics-page">
		<?php include 'includes/page-loader.php'; ?>
		<?php
			include('includes/navbarTop.php');
			include('includes/public-navigation.php');
			?>
		<section class="public-page-hero analytics-intro" aria-labelledby="analyticsHeading">
			<div class="public-page-hero-inner">
				<span class="about-section-kicker">Schools Division of Abra</span>
				<h1 id="analyticsHeading">Learning analytics</h1>
				<p>Explore school, learner, and teacher data to understand progress and identify meaningful next steps.</p>
			</div>
		</section>
		<style>
			body {
			min-height: 100vh;
			background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)),
			url();
			background-attachment: fixed; /* Ensures the image does not move when scrolling */
			background-size: cover; /* Keeps the image from stretching */
			background-position: center; /* Centers the image */
			background-repeat: no-repeat; /* Prevents tiling */
			position: relative;
			overflow-x: hidden;
			}
			* {
			box-sizing: border-box;
			}
			.data-card{
			text-align:center;
			}
			.page-contain {
			display: flex;
			min-height: 100vh;
			align-items: center;
			justify-content: center;
			background: #E7F3F1;
			border: .75em solid white;
			padding: 2em;
			font-family: 'Open Sans', sans-serif;
			}
			.data-card {
			display: flex;
			flex-direction: column;
			max-width: 20.75em;
			min-height: 12.75em;
			overflow: hidden;
			border-radius: .5em;
			text-decoration: none;
			background: white;
			margin: 1em;
			padding: 2.75em 2.5em;
			box-shadow: 0 1.5em 2.5em -.5em rgba(#000000, .1);
			transition: transform .45s ease, background .45s ease;
			h3 {
			color: #2E3C40;
			font-size: 3.5em;
			font-weight: 600;
			line-height: 1;
			padding-bottom: .5em;
			margin: 0 0 0.142857143em;
			border-bottom: 2px solid #753BBD;
			transition: color .45s ease, border .45s ease;
			}
			h4 {
			color: #627084;
			text-transform: uppercase;
			font-size: 1.125em;
			font-weight: 700;
			line-height: 1;
			letter-spacing: 0.1em;
			margin: 0 0 1.777777778em;
			transition: color .45s ease;
			}
			p {
			opacity: 0;
			color: #FFFFFF;
			font-weight: 600;
			line-height: 1.8;
			margin: 0 0 1.25em;
			transform: translateY(-1em);
			transition: opacity .45s ease, transform .5s ease;
			}
			.link-text {
			display: block;
			color: #753BBD;
			font-size: 1.125em;
			font-weight: 600;
			line-height: 1.2;
			margin: auto 0 0;
			transition: color .45s ease;
			svg {
			margin-left: .5em;
			transition: transform .6s ease;
			path {
			transition: fill .45s ease;
			}
			}
			}
			&:hover {
			background: #753BBD;
			transform: scale(1.02);
			h3 {
			color: #FFFFFF;
			border-bottom-color: #A754C4;
			}
			h4 {
			color: #FFFFFF;
			}
			p {
			opacity: 1;
			transform: none;
			}
			.link-text {
			color: #FFFFFF;
			svg {
			animation: point 1.25s infinite alternate;
			path {
			fill: #FFFFFF;
			}
			}
			}
			}
			}
			@keyframes point {
			0% {
			transform: translateX(0);
			}
			100% {
			transform: translateX(.125em);
			}
			}
			.header2 {
			min-height: 15vh;
			width: 100%;
			background-color:transparent;
			position: relative;
			}
		</style>
		<style>
			.bounce-text {
			font-weight: bold;
			color: black;
			display: inline-block;
			animation: bounce 1.5s infinite;
			}
			@keyframes bounce {
			0%, 100% { transform: translateY(0); }
			50% { transform: translateY(-5px); }
			}
			.card{
				  background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
			}/* Minimalist Base Styles */
body {
    min-height: 100vh;
    background: #C5EBB7;
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    position: relative;
    overflow-x: hidden;
}

* {
    box-sizing: border-box;
}

/* Glass Effect Cards */
.glass-card {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-radius: 16px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.glass-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    background: rgba(255, 255, 255, 0.35);
}

/* Main Data Cards */
.data-card {
    display: flex;
    flex-direction: column;
    max-width: 20.75em;
    min-height: 12.75em;
    overflow: hidden;
    border-radius: 16px;
    text-decoration: none;
    margin: 1em;
    padding: 2.75em 2.5em;
    transition: transform 0.45s ease, background 0.45s ease;
}

.data-card h3 {
    color: #2E3C40;
    font-size: 3.5em;
    font-weight: 600;
    line-height: 1;
    padding-bottom: 0.5em;
    margin: 0 0 0.142857143em;
    border-bottom: 2px solid #753BBD;
    transition: color 0.45s ease, border 0.45s ease;
}

.data-card h4 {
    color: #2E3C40;
    text-transform: uppercase;
    font-size: 1.125em;
    font-weight: 700;
    line-height: 1;
    letter-spacing: 0.1em;
    margin: 0 0 1.777777778em;
    transition: color 0.45s ease;
}

.data-card h5 {
    color: #4a5568;
    font-size: 0.9em;
    font-weight: 500;
    line-height: 1.4;
    margin: 0.5em 0;
}

/* Chart Cards */
.chart-card {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
}

.chart-card .card-header {
    background: rgba(255, 255, 255, 0.3);
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    padding: 1rem 1.5rem;
}

.chart-card .card-title {
    color: #2d3748;
    font-weight: 600;
    margin: 0;
    font-size: 1.1em;
}

.chart-card .card-body {
    padding: 1.5rem;
}

/* Bounce Animation */
.bounce-text {
    font-weight: bold;
    color: #2d3748;
    display: inline-block;
    animation: bounce 1.5s infinite;
}

@keyframes bounce {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

/* Header Sections */
.header1, .header2 {
    min-height: 100vh;
    width: 100%;
    background: transparent;
    position: relative;
}

/* Button Styles */
.btn-glass {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    color: #2d3748;
    padding: 0.5rem 1.5rem;
    transition: all 0.3s ease;
}

.btn-glass:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

/* Chart Container Background */
.chart-container {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    padding: 15px;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
    color: #2d3748;
    font-weight: 600;
}

.text-muted {
    color: #718096 !important;
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

/* Responsive Design */
@media (max-width: 768px) {
    .data-card {
        max-width: 100%;
        margin: 0.5em 0;
        padding: 2em 1.5em;
    }
    
    .data-card h3 {
        font-size: 2.5em;
    }
    
    .glass-card {
        margin: 0.5rem 0;
    }
}

/* Fade In Animation */
.fade-in {
    animation: fadeIn 0.8s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Grid Layout Improvements */
.row {
    margin-left: -0.5rem;
    margin-right: -0.5rem;
}

.col-md-4, .col-md-6, .col-md-8, .col-md-12 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

/* Loading States */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top: 2px solid rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: translate(-50%, -50%) rotate(0deg); }
    100% { transform: translate(-50%, -50%) rotate(360deg); }
}
		</style>
		<?php 
		
$positions = [];
$counts = [];

$query = "SELECT position, COUNT(*) as count FROM teachers_profiling GROUP BY position";
$result = mysqli_query($DB, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $positions[] = $row['position'];
        $counts[] = $row['count'];
    }
}

			$teachers_count = 0;
			$learners_count = 0;
			$schools_count = 0;
			$residencecount = mysqli_query($DB, "SELECT * FROM teachers_profiling ORDER BY school_id DESC");
			if (mysqli_num_rows($residencecount) > 0) 
			{
			    while ($row = mysqli_fetch_assoc($residencecount)) 
			    {
			        $teachers_count++;
			    }
			}
			$residencecount = mysqli_query($DB, "SELECT * FROM students ORDER BY school_id DESC");
			if (mysqli_num_rows($residencecount) > 0) 
			{
			    while ($row = mysqli_fetch_assoc($residencecount)) 
			    {
			        $learners_count++;
			    }
			}
			$residencecount = mysqli_query($DB, "SELECT * FROM schools");
			if (mysqli_num_rows($residencecount) > 0) 
			{
			    while ($row = mysqli_fetch_assoc($residencecount)) 
			    {
			        $schools_count++;
			    }
			}
			?>
		<?php
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
			?>
		<?php
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
			?>
		<?php
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
			?>
		<style>
			.header1 {
			min-height: 100vh;
			width: 100%;background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)),
			url();
			background-position: center;
			background-size: cover;
			position: relative;
			}
		</style>
		<section class="header1">
			<div>
				
				<div class="row" style="margin-left:0px; margin-right:0px;">
    <!-- Main Cards (Retained) -->
    <div class="col-md-4 col-xs-6 col-sm-12 mx-auto">
        <center>
            <a href="#" class="data-card" id="toggleTeacherCards" style="
                                    background: rgba(255, 255, 255, 0.35);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh; width:100% !important; float:right;">
                <h3 style="color:black;"><?php echo $teachers_count; ?></h3>
                <h4 style="color:black;">Teachers Count</h4>
                <h5 style="color:black;">Number of active teachers in all districts of Abra</h5>
                <center>
                    <small class="bounce-text" style="font-weight:bold; color:black;">CLICK TO VIEW DETAILS</small>
                </center>
            </a>
        </center>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-12 mx-auto">
        <center>
            <a href="#" class="data-card" id="toggleLearnerCards" style="
                                    background: rgba(255, 255, 255, 0.35);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh; width:100% !important; float:center;">
                <h3 style="color:black;"><?php echo $learners_count; ?></h3>
                <h4 style="color:black;">Learners Count</h4>
                <h5 style="color:black;">Number of active learners in all districts of Abra</h5>
                <center>
                    <small class="bounce-text" style="font-weight:bold; color:black;">CLICK TO VIEW DETAILS</small>
                </center>
            </a>
        </center>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-12 mx-auto">
        <center>
            <a href="#" class="data-card" id="toggleSchoolCards" style="
                                    background: rgba(255, 255, 255, 0.35);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh; width:100% !important;float:left;">
                <h3 style="color:black;"><?php echo $schools_count; ?></h3>
                <h4 style="color:black;">Schools Count</h4>
                <h5 style="color:black;">Number of active schools in all districts of Abra</h5>
                <center>
                    <small class="bounce-text" style="font-weight:bold; color:black;">CLICK TO VIEW DETAILS</small>
                </center>
            </a>
        </center>
    </div>
</div>

<!-- Learners Details (Charts) -->
<div id="learnerCharts" style="display: none; margin-top: 20px;">
    <div class="row">
    	<div class="col-md-2"></div>
        <div class="col-md-4">
            
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Economic Status</h3>
                </div>
                <div class="card-body">
                    <canvas id="economicBarChart" style="background-color:white;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Grade Level Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="gradeBarChart" style="background-color:white;"></canvas>
                </div>
            </div>
        </div>
    	<div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
    	<div class="col-md-2"></div>
        <div class="col-md-4">
            
            
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Gender Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="genderPieChart" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh; 
                                    height: 200px !important; 
                                    width: 200px !important;
                                    ">
                        
                    </canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Attendance Status</h3>
                </div>
                <div class="card-body">
                    <canvas id="attendancePieChart" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh; 
                                    height: 200px !important; 
                                    width: 200px !important;
                                    "></canvas>
                </div>
            </div>
        </div>
    	<div class="col-md-2"></div>
    </div>
    <div class="row">
    	<div class="col-md-2"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Extra-Curricular Participation</h3>
                </div>
                <div class="card-body">
                    <canvas id="extracurricularPieChart" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh; 
                                    height: 200px !important; 
                                    width: 200px !important;
                                    "></canvas>
                </div>
            </div>
        </div>
    	<div class="col-md-2"></div>
    </div>
</div>

<!-- Teachers Details (Charts) -->
<div id="teacherCharts" style="display: none; margin-top: 20px;">
    <div class="row">
    	<div class="col-md-2"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Teacher Gender Distribution</h3>
                </div>
                <div class="card-body">
                    <canvas id="teacherGenderPieChart" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Education Levels</h3>
                </div>
                <div class="card-body">
                    <canvas id="educationPieChart" style="
                                                        background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;"></canvas>
                </div>
            </div>
        </div>
    	<div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
    	<div class="col-md-2"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Teacher Positions</h3>
                </div>
                <div class="card-body">
                    <canvas id="positionBarChart" style="background-color:white;;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Major Specializations</h3>
                </div>
                <div class="card-body">
                    <canvas id="majorBarChart" style="background-color:white;"></canvas>
                </div>
            </div>
        </div>
    	<div class="col-md-2"></div>
    </div>
</div>

<!-- Schools Details (Charts) -->
<div id="schoolCharts" style="display: none; margin-top: 20px;">
    <div class="row">
    	<div class="col-md-2"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">School Accessibility</h3>
                </div>
                <div class="card-body">
                    <canvas id="accessibilityPieChart" style="
                                                        background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">School Facilities</h3>
                </div>
                <div class="card-body">
                    <canvas id="facilitiesPieChart" style="
                                                        background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;"></canvas>
                </div>
            </div>
        </div>
    	<div class="col-md-2"></div>
    </div>
    <br>
    <div class="row">
    	<div class="col-md-2"></div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Internet Connectivity</h3>
                </div>
                <div class="card-body">
                    <canvas id="internetPieChart" style="
                                                        background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Chart Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Toggle functions
document.getElementById("toggleTeacherCards").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("teacherCharts").style.display = 
        (document.getElementById("teacherCharts").style.display === "none") ? "block" : "none";
    document.getElementById("learnerCharts").style.display = "none";
    document.getElementById("schoolCharts").style.display = "none";
    
    // Initialize charts when shown
    if (document.getElementById("teacherCharts").style.display === "block") {
        initTeacherCharts();
    }
});

document.getElementById("toggleLearnerCards").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("learnerCharts").style.display = 
        (document.getElementById("learnerCharts").style.display === "none") ? "block" : "none";
    document.getElementById("teacherCharts").style.display = "none";
    document.getElementById("schoolCharts").style.display = "none";
    
    if (document.getElementById("learnerCharts").style.display === "block") {
        initLearnerCharts();
    }
});

document.getElementById("toggleSchoolCards").addEventListener("click", function(event) {
    event.preventDefault();
    document.getElementById("schoolCharts").style.display = 
        (document.getElementById("schoolCharts").style.display === "none") ? "block" : "none";
    document.getElementById("teacherCharts").style.display = "none";
    document.getElementById("learnerCharts").style.display = "none";
    
    if (document.getElementById("schoolCharts").style.display === "block") {
        initSchoolCharts();
    }
});

// Chart initialization functions
function initLearnerCharts() {
  
// Gender Pie Chart
new Chart(document.getElementById('genderPieChart'), {
    type: 'pie',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [<?php echo $male_count; ?>, <?php echo $female_count; ?>],
            backgroundColor: ['#36a2eb', '#ff6384']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black', // Legend text color
                    font: {
                        size: 16 // Legend font size
                    }
                }
            }
        }
    }
});

// Attendance Pie Chart
new Chart(document.getElementById('attendancePieChart'), {
    type: 'pie',
    data: {
        labels: ['Excellent', 'Satisfactory', 'Poor'],
        datasets: [{
            data: [<?php echo $excellent_attendance; ?>, <?php echo $satisfactory_attendance; ?>, <?php echo $poor_attendance; ?>],
            backgroundColor: ['#4bc0c0', '#ffcd56', '#ff6384']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black', // Set legend text color to white
                    font: {
                        size: 16 // Set legend font size
                    }
                }
            }
        }
    }
});

    // Grade Level Bar Chart
    new Chart(document.getElementById('gradeBarChart'), {
        type: 'bar',
        data: {
            labels: [<?php echo implode(',', array_map(function($g) { return "'$g'"; }, array_keys($grade_counts))); ?>],
            datasets: [{
                label: 'Students',
                data: [<?php echo implode(',', $grade_counts); ?>],
                backgroundColor: '#4bc0c0'
            }]
        }
    });

    // Economic Status Bar Chart
    new Chart(document.getElementById('economicBarChart'), {
        type: 'bar',
        data: {
            labels: ['Low', 'Middle', 'High'],
            datasets: [{
                label: 'Students',
                data: [<?php echo $low_econ; ?>, <?php echo $middle_econ; ?>, <?php echo $high_econ; ?>],
                backgroundColor: ['#ff9f40', '#ffcd56', '#4bc0c0']
            }]
        }
    });
// Extra-Curricular Pie Chart
new Chart(document.getElementById('extracurricularPieChart'), {
    type: 'pie',
    data: {
        labels: ['Athletes', 'Academic Contest', 'No Extra-Curricular'],
        datasets: [{
            data: [<?php echo $athlete_count; ?>, <?php echo $academic_contest; ?>, <?php echo $no_extracurricular; ?>],
            backgroundColor: ['#36a2eb', '#ff6384', '#ffcd56']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black', // Legend text color
                    font: {
                        size: 16 // Legend font size
                    }
                }
            }
        }
    }
});

}

function initTeacherCharts() {
    // Teacher Gender Pie Chart
// Teacher Gender Pie Chart
new Chart(document.getElementById('teacherGenderPieChart'), {
    type: 'pie',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            data: [<?php echo $data_teachers['male_teachers']; ?>, <?php echo $data_teachers['female_teachers']; ?>],
            backgroundColor: ['#36a2eb', '#ff6384']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black', // Legend text color
                    font: {
                        size: 16 // Legend font size
                    }
                }
            }
        }
    }
});

// Education Pie Chart
new Chart(document.getElementById('educationPieChart'), {
    type: 'pie',
    data: {
        labels: ['Bachelor', 'Master', 'Doctorate'],
        datasets: [{
            data: [
                <?php echo $data_teachers['bachelor_count']; ?>, 
                <?php echo $data_teachers['master_count']; ?>, 
                <?php echo $data_teachers['doctorate_count']; ?>
            ],
            backgroundColor: ['#ff9f40', '#ff6384', '#36a2eb']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black', // Set legend text color to white
                    font: {
                        size: 16 // Set legend font size
                    }
                }
            }
        }
    }
});


    new Chart(document.getElementById('positionBarChart'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($positions); ?>,
            datasets: [{
                label: 'Teachers',
                data: <?php echo json_encode($counts); ?>,
                backgroundColor: '#4bc0c0'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
    // Major Bar Chart
    new Chart(document.getElementById('majorBarChart'), {
        type: 'bar',
        data: {
            labels: [<?php echo implode(',', array_map(function($m) { return "'$m'"; }, array_keys($major_counts))); ?>],
            datasets: [{
                label: 'Teachers',
                data: [<?php echo implode(',', $major_counts); ?>],
                backgroundColor: '#ff9f40'
            }]
        }
    });
}

function initSchoolCharts() {
// Accessibility Pie Chart
new Chart(document.getElementById('accessibilityPieChart'), {
    type: 'pie',
    data: {
        labels: ['Highly Accessible', 'Moderately Accessible', 'Last Mile'],
        datasets: [{
            data: [<?php echo $highly_accessible; ?>, <?php echo $moderately_accessible; ?>, <?php echo $last_mile_schools; ?>],
            backgroundColor: ['#4bc0c0', '#ffcd56', '#ff6384']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black',
                    font: {
                        size: 16
                    }
                }
            }
        }
    }
});

// Facilities Pie Chart
new Chart(document.getElementById('facilitiesPieChart'), {
    type: 'pie',
    data: {
        labels: ['Fully Equipped', 'Moderately Equipped', 'Minimally Equipped'],
        datasets: [{
            data: [<?php echo $fully_equipped; ?>, <?php echo $moderately_equipped; ?>, <?php echo $minimally_equipped; ?>],
            backgroundColor: ['#4bc0c0', '#ffcd56', '#ff6384']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black',
                    font: {
                        size: 16
                    }
                }
            }
        }
    }
});

// Internet Pie Chart
new Chart(document.getElementById('internetPieChart'), {
    type: 'pie',
    data: {
        labels: ['High Speed', 'Average Speed', 'No Internet'],
        datasets: [{
            data: [<?php echo $high_speed; ?>, <?php echo $average_speed; ?>, <?php echo $no_internet; ?>],
            backgroundColor: ['#4bc0c0', '#ffcd56', '#ff6384']
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: {
                    color: 'black',
                    font: {
                        size: 16
                    }
                }
            }
        }
    }
});

}
</script>
				
				
				<div class="row" style="margin-left:0px; margin-right:0px;">
					<div class="col-md-12 col-xs-12 col-sm-12">
						<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
						<br>
						<?php
							$selected_grade = isset($_GET['grade_level']) && $_GET['grade_level'] !== "" ? " (Grade " . $_GET['grade_level'] . ")" : "";
							?>
						<div class="row" style="margin-top:-1vh;">
						    <div class="col-md-2 col-xs-12 col-sm-12"></div><div class="col-md-4 col-xs-12 col-sm-12" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;
                                ">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mean Percentage Score Trends<?php echo $selected_grade; ?></h3>
                </div>
                <div class="card-body">
								<canvas id="trendChart"  style="background-color:white;"></canvas>
							</div>
						</div>
							</div><div class="col-md-4 col-xs-12 col-sm-12" style="
                                        background: rgba(255, 255, 255, 0.15);
                                        backdrop-filter: blur(10px);
                                        -webkit-backdrop-filter: blur(10px);
                                        border-radius: 10px;
                                        border: 1px solid rgba(255, 255, 255, 0.3);
                                        padding: 3vh;
                                    ">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Level of Proficiency Trends<?php echo $selected_grade; ?></h3>
                </div>
                <div class="card-body">
								<canvas id="quarterlyChart"  style="background-color:white;"></canvas>
							</div>
						</div>
							</div>
						    <div class="col-md-2 col-xs-12 col-sm-12"></div>
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
							$periodNumber = filter_var($row['quarter'], FILTER_VALIDATE_INT);
							if ($periodNumber === false || $periodNumber < 1 || $periodNumber > 4) {
							    continue;
							}
							$periodLabel = $periodNumber <= 3 ? "Term " . $periodNumber : "Legacy 4";
							$data[$periodLabel]['english'] = $row['english_mps'];
							$data[$periodLabel]['filipino'] = $row['filipino_mps'];
							$data[$periodLabel]['aralpan'] = $row['aralpan_mps'];
							$data[$periodLabel]['esp'] = $row['esp_mps'];
							$data[$periodLabel]['math'] = $row['math_mps'];
							$data[$periodLabel]['science'] = $row['science_mps'];
							$data[$periodLabel]['mapeh'] = $row['mapeh_mps'];
							$data[$periodLabel]['tle'] = $row['tle_mps'];
							}
							
							$jsonData = json_encode($data);
							?>
						<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
						<script>
							var ctx = document.getElementById("trendChart").getContext("2d");
							
							var chartData = <?php echo $jsonData; ?>;
							var periodLabels = ["Term 1", "Term 2", "Term 3", "Legacy 4"];
							var subjects = ["english", "filipino", "aralpan", "esp", "math", "science", "mapeh", "tle"];
							
							var datasets = subjects.map((subject, index) => ({
							    label: subject.charAt(0).toUpperCase() + subject.slice(1),
							    data: periodLabels.map(period => chartData[period] ? chartData[period][subject] : 0),
							    borderColor: `hsl(${index * 45}, 70%, 50%)`,
							    fill: false,
							    tension: 0.3
							}));
							
							var trendChart = new Chart(ctx, {
							    type: "line",
							    data: {
							        labels: periodLabels,
							        datasets: datasets
							    },
							    options: {
							        responsive: true,
							        plugins: {
							            legend: { display: true }
							        },
							        scales: {
							            x: { title: { display: true, text: "Term / legacy period" } },
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
							   let periodLabels = ["Term 1", "Term 2", "Term 3", "Legacy 4"];
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
							
							   // Keep legacy period 4 visible without treating it as a current term.
							   subjectsg1.forEach(subject => {
							       dataset[subject] = [0, 0, 0, 0];
							   });
							
							   chartDatag1.forEach(row => {
							       const periodNumber = Number(row.quarter);
							       if (!Number.isInteger(periodNumber) || periodNumber < 1 || periodNumber > 4) return;
							       const periodIndex = periodNumber - 1;
							
							       subjectsg1.forEach(subject => {
							           dataset[subject][periodIndex] = row["avg_" + subject] ? row["avg_" + subject] : 0;
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
							           labels: periodLabels,
							           datasets: dataSetsFormattedb1
							       },
							       options: {
							           responsive: true,
							           plugins: {
							               legend: { display: true }
							           },
							           scales: {
							               x: { title: { display: true, text: "Term / legacy period" } },
							               y: { title: { display: true, text: "AVG Grades (%)" } }
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
						<div class="row">
						    <div class="col-md-2 col-xs-12 col-sm-12"></div><div class="col-md-4 col-xs-12 col-sm-12" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;
                                ">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Level of Proficiency Trends ( Grade 11 )</h3>
                </div>
                <div class="card-body">
								<canvas id="quarterlyChart2" style="background-color:white;"></canvas>
							</div>
						</div>
							</div><div class="col-md-4 col-xs-12 col-sm-12" style="
                                    background: rgba(255, 255, 255, 0.15);
                                    backdrop-filter: blur(10px);
                                    -webkit-backdrop-filter: blur(10px);
                                    border-radius: 10px;
                                    border: 1px solid rgba(255, 255, 255, 0.3);
                                    padding: 3vh;
                                ">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Level of Proficiency Trends ( Grade 12 )</h3>
                </div>
                <div class="card-body">
								<canvas id="quarterlyChart3"  style="background-color:white;"></canvas>
							</div>
						</div>
							</div>
						    <div class="col-md-2 col-xs-12 col-sm-12"></div>
						</div>
						<script>
							document.addEventListener("DOMContentLoaded", function () {
							    let periodLabels = ["Term 1", "Term 2", "Term 3", "Legacy 4"];
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
							
							    // Keep legacy period 4 visible without treating it as a current term.
							    subjects.forEach(subject => {
							        dataset[subject] = [0, 0, 0, 0];
							    });
							
							    chartData.forEach(row => {
							        const periodNumber = Number(row.quarter);
							        if (!Number.isInteger(periodNumber) || periodNumber < 1 || periodNumber > 4) return;
							        const periodIndex = periodNumber - 1;
							
							        subjects.forEach(subject => {
							            dataset[subject][periodIndex] = row["avg_" + subject] ? row["avg_" + subject] : 0;
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
							            labels: periodLabels,
							            datasets: formattedDatasets
							        },
							        options: {
							            responsive: true,
							            plugins: {
							                legend: { display: true }
							            },
							            scales: {
							                x: { title: { display: true, text: "Term / legacy period" } },
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
						<script>
							document.addEventListener("DOMContentLoaded", function () {
							    let periodLabels = ["Term 1", "Term 2", "Term 3", "Legacy 4"];
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
							        dataset[subject] = [0, 0, 0, 0];
							    });
							
							    chartData.forEach(row => {
							        const periodNumber = Number(row.quarter);
							        if (!Number.isInteger(periodNumber) || periodNumber < 1 || periodNumber > 4) return;
							        const periodIndex = periodNumber - 1;
							
							        subjects.forEach(subject => {
							            dataset[subject][periodIndex] = row["avg_" + subject] ? row["avg_" + subject] : 0;
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
							            labels: periodLabels,
							            datasets: formattedDatasets
							        },
							        options: {
							            responsive: true,
							            plugins: {
							                legend: { display: true }
							            },
							            scales: {
							                x: { title: { display: true, text: "Term / legacy period" } },
							                y: { title: { display: true, text: "AVG Grades (%)" } }
							            }
							        }
							    });
							});
							
						</script>
					</div>
					<div class="col-md-12 col-xs-12 col-sm-12"></div>
				</div>	
			</div>
		</section>
		<?php
			include('footer.php');
			?>
	</body>
</html>