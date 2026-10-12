<?php
   include('includes/header.php');
   
   
$quarter = isset($_GET['quarter']) ? intval($_GET['quarter']) : 1;

// Get all schools
$schoolsQuery = "SELECT * FROM schools";
$schoolsResult = mysqli_query($DB, $schoolsQuery);

$schools = [];
while ($row = mysqli_fetch_assoc($schoolsResult)) {
    $schools[$row['school_id']] = [
        'name' => $row['school_name'],
        'district' => $row['district']
    ];
}

// Get submitted schools for the selected quarter
$submittedQuery = "SELECT DISTINCT school_id FROM learners_grade WHERE quarter = $quarter";
$submittedResult = mysqli_query($DB, $submittedQuery);

$submittedSchools = [];
while ($row = mysqli_fetch_assoc($submittedResult)) {
    $submittedSchools[] = $row['school_id'];
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
                     window.location.href = 'manage_school.php';
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
                         window.location.href = 'manage_school.php';
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
               <h1 class="m-0">Schools Submission Details - Term <?php echo $quarter; ?></h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6 accent-blue">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Viewing Information</li>
               </ol>
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <style>
      .submitted-row {
    background-color: white !important; /* Light green */
}

.not-submitted-row {
    background-color: #f8d7da !important; /* Light red */
}

   </style>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="card">
            <div class="card-body">
             <table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>School Name</th>
            <th>School ID</th>
            <th>School District</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($schools as $school_id => $school) {
            $i++;
            $isSubmitted = in_array($school_id, $submittedSchools);
            $status = $isSubmitted ? "<span style='color: green;'>Submitted</span>" : "<span style='color: red;'>Not Submitted</span>";
            $rowClass = $isSubmitted ? "submitted-row" : "not-submitted-row";
        ?>
            <tr class="<?php echo $rowClass; ?>">
                <td><?php echo $i; ?></td>
                <td><?php echo $school['name']; ?></td>
                <td><?php echo $school_id; ?></td>
                <td><?php echo $school['district']; ?></td>
                <td><?php echo $status; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>


            </div>
            <!-- /.card-body -->
         </div>
      </div>

   </section>
   <!-- /.content -->
</div>
<?php
   include('includes/footer.php');
   ?>