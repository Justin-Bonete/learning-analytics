<?php
    include('includes/header.php');
    include('includes/topbar.php');
    include('includes/sidebar.php');
    include('includes/modals.php');


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
$query = "SELECT quarter, COUNT(DISTINCT school_id) AS submitted_schools 
          FROM (
              SELECT quarter, school_id FROM learners_grade
              UNION ALL
              SELECT quarter, school_id FROM learners_grade_shs
          ) AS combined
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
                    <h1 class="m-0">School Submissions Analytics Report</h1>
                </div><!-- /.col -->
                <div class="col-sm-6 accent-blue">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">School Submissions</li>
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

                <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>

               <center><h3><b>Schools Submission Status per Term of <?php echo date('Y'); ?></b></h3></center>

    <div style="display: flex; flex-wrap: wrap; justify-content: center;">
        <?php 

$quarterMap = [
    "First Term" => 1,
    "Second Term" => 2,
    "Third Term" => 3,
    "Fourth Term" => 4
];
        ?>
        <?php foreach ($chartData as $quarter => $data) { ?>
            <div style="width: 300px; margin: 20px;">
                <canvas id="chart_<?php echo $quarter; ?>"></canvas>
                <p style="text-align: center; font-weight: bold;"><?php echo $quarter; ?></p>
<a href="view_pie.php?quarter=<?php echo $quarterMap[$quarter]; ?>" 
                   class="btn btn-primary" style="display: block; text-align: center; margin-top: 10px;">
                   View Information
                </a>
            </div>
        <?php } ?>
    </div><script>
    var chartData = <?php echo json_encode($chartData); ?>;

    Object.keys(chartData).forEach(quarter => {
        var ctx = document.getElementById('chart_' + quarter).getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Submitted', 'Not Submitted'],
                datasets: [{
                    data: [chartData[quarter].submitted, chartData[quarter].not_submitted],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                let dataset = tooltipItem.dataset.data;
                                let value = dataset[tooltipItem.dataIndex];
                                return value + " Schools"; // Display as "X Schools"
                            }
                        }
                    }
                }
            }
        });
    });
</script>


         
            <!-- /.row -->
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