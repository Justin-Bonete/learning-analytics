<?php
   include('includes/header.php');
   
   
    // Add this near your other form actions
if(isset($_POST['resetPassword'])) {
    $user_ID = $_POST['user_ID'];
    $password = md5($_POST['newpassword']); // Reset to school ID as default password
    
    $query = "UPDATE schools SET password = '$password' WHERE school_id = '$user_ID'";
    $result = mysqli_query($DB, $query);

    if ($result) {
        showSweetAlertSucced2("Success!", "Password has been reset successfully.", "success");  
    } else {
        $error = "Error resetting password: " . mysqli_error($DB);
        showSweetAlertFailed2("Failed!", $error, "error");
    }
}
    
   if(isset($_POST['deleteuser']))
   {
       $USER_IDS = $_POST['user_ID_Delete'];
   
       $query = "DELETE FROM schools WHERE id = '$USER_IDS'";
       $result = mysqli_query($DB, $query);
   
       if ($result) {    
               unset($_POST['user_ID_Delete']);  
               unset($_POST['deleteuser']);         
           showSweetAlertSucced2("Success!", "School has been deleted successfully.", "success");  
       } else {
               unset($_POST['user_ID_Delete']); 
               unset($_POST['deleteuser']);  
           $error = "Error deleting user: " . mysqli_error($DB);
           showSweetAlertFailed2("Failed!", $error, "error");
       }
   
   }if (isset($_POST['updateSchoolInfo'])) {
       $validation = 1;
       $schoolID = $_POST['school_id'];
       $school_name = $_POST['school_name'];
       $email = $_POST['email'];
       $accessibility = $_POST['accessibility'];
       $facilities = $_POST['facilities'];
       $internetconnectivity = $_POST['internetconnectivity'];
       $email_status = $_POST['email_status'];
       $status = $_POST['status'];
   
       if ($validation == 1) {
           $query = "UPDATE schools SET 
                       school_name = '$school_name',
                       email = '$email',
                       accessibility = '$accessibility',
                       facilities = '$facilities',
                       internetconnectivity = '$internetconnectivity',
                       email_status = '$email_status',
                       status = '$status'
                     WHERE school_id = $schoolID";
   
           $result = mysqli_query($DB, $query);
   
           if ($result) {             
               unset($_POST['updateSchoolInfo']);
               showSweetAlertSucced2("Success!", "School profile has been updated successfully.", "success");  
           } else {
               $error = "Error updating profile: " . mysqli_error($DB);
               unset($_POST['updateSchoolInfo']);
               showSweetAlertFailed2("Failed!", $error, "error");
           }
       }
   }
   if (isset($_POST['addSchool'])) {
      $district= mysqli_real_escape_string($DB, $_POST['district']);
       $schoolid = mysqli_real_escape_string($DB, $_POST['schoolid']);
       $school_name = mysqli_real_escape_string($DB, $_POST['school_name']);
       $email = mysqli_real_escape_string($DB, $_POST['school_email']);
       $password = md5($school_name.' '.$schoolid); // Consider hashing this before storing
       $accessibility = mysqli_real_escape_string($DB, $_POST['accessibility']);
       $facilities = mysqli_real_escape_string($DB, $_POST['facilities']);
       $internetconnectivity = mysqli_real_escape_string($DB, $_POST['internet_connectivity']);
   
        $email_status = 'Active';
        $status = 'Active';
   
       $insertQuery = "INSERT INTO schools 
           (school_id, school_name, email, password, accessibility, facilities, internetconnectivity, email_status, status, district) 
           VALUES 
           ('$schoolid','$school_name', '$email', '$password', '$accessibility', '$facilities', '$internetconnectivity', '$email_status', '$status', '$district')";
   
       if (mysqli_query($DB, $insertQuery)) {
           showSweetAlertSucced2("Success!", "New school added successfully.", "success");
       } else {
           $error = "Error: " . mysqli_error($DB);
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
               <h1 class="m-0">Manage School</h1>
            </div>
            <!--
<?php
/*
if (isset($_POST["submitgb"])) {
    if (isset($_FILES["csv_file"]) && $_FILES["csv_file"]["error"] == 0) {
        $file = $_FILES["csv_file"]["tmp_name"];
        $handle = fopen($file, "r");

        // Skip the header row if necessary
        fgetcsv($handle);
        
        // Database connection
        $conn = $DB;
        
        $rowCount = 0; // Initialize counter

        while (($data = fgetcsv($handle, 319, ",")) !== FALSE) {
            $rowCount++;
            if ($rowCount > 318) break; // Stop after 318 rows
            
            $school_id = $conn->real_escape_string($data[0]);
            $school_name = $conn->real_escape_string($data[1]);
            $district = ucfirst(strtolower($conn->real_escape_string($data[2])));
            $email = $conn->real_escape_string($data[3]);
            
            $password = "81dc9bdb52d04dc20036dbd8313ed055"; // Predefined password
            $email_status = "Active";
            $status = "Active";
            $accessibility = "High Accessible";
            $facilities = "Fully Equipped";
            $internetconnectivity = "High Speed";
            
            $sql = "INSERT INTO schools (school_id, school_name, district, password, email, email_status, status, accessibility, facilities, internetconnectivity) 
                    VALUES ('$school_id', '$school_name', '$district', '$password', '$email', '$email_status', '$status', '$accessibility', '$facilities', '$internetconnectivity')";
            
            $conn->query($sql);
        }
        
        fclose($handle);
        echo "Inserted first 318 rows successfully.";
    } else {
        echo "Error uploading file.";
    }
}*/
?>

    <form method="post" enctype="multipart/form-data">
        <input type="file" name="csv_file" required>
        <button type="submit" name="submitgb">Upload</button>
    </form>
            -->
            <!-- /.col -->
            <div class="col-sm-6 accent-blue">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                  <li class="breadcrumb-item active">Manage School</li>
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
               <div class="row">
                  <div class="form-group col-md-3">
                     <form method="POST">
                         <label for="district">Filter by District:</label>
                         <select class="form-control" name="district" onchange="this.form.submit()">
                             <option value="">All Districts</option>
                             <?php
                             $districts = ["Bangued", "Bucay", "La Paz", "Lagangilang", "Luba", "Dolores", "Pidigan", "San Juan", "Pilar", "Sallapadan"];
                             foreach ($districts as $district) {
                                 $selected = (isset($_POST['district']) && $_POST['district'] == $district) ? 'selected' : '';
                                 echo "<option value='$district' $selected>$district</option>";
                             }
                             ?>
                         </select>
                     </form>
                  </div>

                  <div class="form-group col-md-3">
                        <br>
            <?php if($_SESSION['is_superadmin'] == '1'){ ?>
                        <button style="margin-top:0.8vh;" type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#addSchoolModal">
                        Add School <i class="fas fa-plus"></i>
                        </button>
                        <?php } ?>
                  </div>
            </div>
               <table id="example2" class="table table-bordered table-striped">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>School Name</th>
                        <th>School ID</th>
                        <th>School District</th>
                        <th>Accessibility</th>
                        <th>Facilities</th>
                        <th>Internet Connectivity</th>
                        <th>Verified</th>
                        <th>Status</th>
                        
            <?php if($_SESSION['is_superadmin'] == '1'){ ?>
                        <th>Action</th>
                        <?php } ?>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $i = 0;
                        // ✅ Apply filtering based on selected district
                        $districtFilter = "";
                        if (isset($_POST['district']) && $_POST['district'] !== "") {
                            $selectedDistrict = mysqli_real_escape_string($DB, $_POST['district']);
                            $districtFilter = " WHERE district = '$selectedDistrict'";
                        }

                        // ✅ Fetch schools with applied district filter
                        $schoolQuery = mysqli_query($DB, "SELECT * FROM schools $districtFilter");

                        if (mysqli_num_rows($schoolQuery) > 0) {
                            while ($row = mysqli_fetch_assoc($schoolQuery)) {
                                $i++;
                                $school_ID = $row['id']; // Use the school ID for actions like Edit/Delete

                                $verified = 'No';
                                if($row['email_status'] == 'Active'){
                                    $verified = 'Yes';
                                }
                        ?>
                     <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row['school_name']; ?></td>
                        <td><?php echo $row['school_id']; ?></td>
                        <td><?php echo $row['district']; ?></td>
                        <td><?php echo $row['accessibility']; ?></td>
                        <td><?php echo $row['facilities']; ?></td>
                        <td><?php echo $row['internetconnectivity']; ?></td>
                        <td><?php echo $verified; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        
            <?php if($_SESSION['is_superadmin'] == '1'){ ?>
                        <td align="center">
                           <div class="btn-group">
                              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#manageSchool<?php echo $school_ID; ?>"> <span class="d-lg-block d-lg-none d-xl-none">Edit</span><i class="fas fa-edit"></i> </button>
                              <div class="modal fade" id="manageSchool<?php echo $school_ID; ?>">
                                 <div class="modal-dialog">
                                    <div class="modal-content">
                                       <form action="" method="post" enctype="multipart/form-data">
                                          <div class="modal-header">
                                             <h4 class="modal-title">Manage School</h4>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <input type="hidden" name="school_id" value="<?php echo $row['school_id']; ?>">
                                             <div class="form-group">
                                                <label for="school_name">School Name</label>
                                                <input type="text" name="school_name" class="form-control" value="<?php echo $row['school_name']; ?>">
                                             </div>
                                             <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>">
                                             </div>
                                             <div class="row mx-0">
                                                <div class="col-md-12">
                                                   <div class="form-group mb-3">
                                                      <label for="accessibility">Accessibility:</label>
                                                      <select id="accessibility" name="accessibility" class="form-control" required>
                                                         <option value="">Select Accessibility</option>
                                                         <option value="Highly Accessible" <?php echo ($row['accessibility'] == 'Highly Accessible') ? 'selected' : ''; ?>>Highly Accessible Schools – situated in urban areas, easily reachable by public transportation.</option>
                                                         <option value="Moderately Accessible" <?php echo ($row['accessibility'] == 'Moderately Accessible') ? 'selected' : ''; ?>>Moderately Accessible Schools - Found in semi-urban or rural areas with developing infrastructure, accessible by public transportation, but may require longer travel times or multiple transfers.</option>
                                                         <option value="Last Mile Schools" <?php echo ($row['accessibility'] == 'Last Mile Schools') ? 'selected' : ''; ?>>Last Mile Schools - Located in remote, rural, or mountainous areas, difficult to reach, often requiring long travel times, multiple modes of transport, or even walking.</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-12">
                                                   <div class="form-group mb-3">
                                                      <label for="facilities">Facilities:</label>
                                                      <select id="facilities" name="facilities" class="form-control" required>
                                                         <option value="">Select Level</option>
                                                         <option value="Fully Equipped" <?php echo ($row['facilities'] == 'Fully Equipped') ? 'selected' : ''; ?>>Fully Equipped School – With complete classrooms, computer laboratory, science laboratory, library, SLRC, sports and health facilities.</option>
                                                         <option value="Moderately Equipped" <?php echo ($row['facilities'] == 'Moderately Equipped') ? 'selected' : ''; ?>>Moderately Equipped Schools – With basic functional classrooms, shared classrooms, basic laboratories, basic sports and health facilities.</option>
                                                         <option value="Minimally Equipped" <?php echo ($row['facilities'] == 'Minimally Equipped') ? 'selected' : ''; ?>>Minimally Equipped Schools – Basic classrooms that need repairs, limited or no laboratories, limited or no health services, limited or no sports facilities.</option>
                                                      </select>
                                                   </div>
                                                </div>
                                                <div class="col-md-12">
                                                   <div class="form-group mb-3">
                                                      <label for="internetconnectivity">Internet Connectivity:</label>
                                                      <select id="internetconnectivity" name="internetconnectivity" class="form-control" required>
                                                         <option value="">Select Type</option>
                                                         <option value="High speed internet" <?php echo ($row['internetconnectivity'] == 'High speed internet') ? 'selected' : ''; ?>>High speed internet (200mbps and above)</option>
                                                         <option value="Average speed internet" <?php echo ($row['internetconnectivity'] == 'Average speed internet') ? 'selected' : ''; ?>>Average speed internet (below 200 mbps)</option>
                                                         <option value="No internet" <?php echo ($row['internetconnectivity'] == 'No internet') ? 'selected' : ''; ?>>No internet</option>
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="form-group">
                                                <label for="email_status">Email Status</label>
                                                <select name="email_status" class="form-control">
                                                   <option value="Active" <?php echo ($row['email_status'] == 'Active') ? 'selected' : ''; ?>>Verified</option>
                                                   <option value="Inactive" <?php echo ($row['email_status'] == 'Inactive') ? 'selected' : ''; ?>>Unverified</option>
                                                </select>
                                             </div>
                                             <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control">
                                                   <option value="Active" <?php echo ($row['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                                   <option value="Inactive" <?php echo ($row['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="modal-footer">
                                             <button type="submit" class="btn btn-success" name="updateSchoolInfo">Update <i class="fas fa-edit"></i></button>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              <!--<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUsers<?php echo $school_ID; ?>"> <span class="d-lg-block d-lg-none d-xl-none">Delete</span><i class="fas fa-trash"></i> </button>-->
                              
        <!-- New Reset Password Button -->
        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#resetPasswordModal<?php echo $row['school_id']; ?>">
            <span class="d-lg-block d-lg-none d-xl-none">Reset PW</span><i class="fas fa-key"></i>
        </button>
        <!-- Reset Password Modal -->
        <form action="" method="post">
            <div class="modal fade" id="resetPasswordModal<?php echo $row['school_id']; ?>">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Reset Password</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <?php  
                                $randomNumber = $user_ID . time() . rand(1000, 9999);
                                                                $randompassword = $randomNumber;
                            ?>
                            <p>Are you sure you want to reset the password for <?php echo $row['school_name']; ?>?</p>
                            <p>The password will be reset to (<?php echo $randompassword; ?>).</p>
                            <input type="hidden" name="user_ID" value="<?php echo $row['school_id']; ?>">
                            <input type="hidden" name="newpassword" value="<?php echo $randompassword; ?>" />
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning" name="resetPassword">Reset Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
        
                              <form action="" method="post">
                                 <div class="modal fade" id="deleteUsers<?php echo $school_ID; ?>">
                                    <div class="modal-dialog">
                                       <div class="modal-content">
                                          <div class="modal-header">
                                             <h4 class="modal-title">Deleting School Account</h4>
                                             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                             </button>
                                          </div>
                                          <div class="modal-body">
                                             <p>Are you sure you want to delete this School Account?</p>
                                          </div>
                                          <div class="modal-footer justify-content-end">
                                             <input type="hidden" name="user_ID_Delete" id="user_ID_Delete" value="<?php echo $school_ID; ?>">
                                             <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                             <button type="submit" class="btn btn-danger" id="deleteuser" name="deleteuser">Confirm</button>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </td>
                        <?php } ?>
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
      <div class="modal fade" id="addSchoolModal">
         <div class="modal-dialog">
            <div class="modal-content">
               <form action="" method="post">
                  <div class="modal-header">
                     <h4 class="modal-title">Add New School</h4>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                  <div class="modal-body">

                      <div class="form-group">
                          <label class="form-label">District <span style="color:red;">*</span></label>
                          <select class="form-control" id="district" name="district" required>
                              <option value="">Select District</option>
                              <?php
                              $districts = ["Bangued", "Bucay", "La Paz", "Lagangilang", "Luba", "Dolores", "Pidigan", "San Juan", "Pilar", "Sallapadan"];
                              foreach ($districts as $district) {
                                  $selected = (isset($_POST['district']) && $_POST['district'] == $district) ? 'selected' : '';
                                  echo "<option value='$district' $selected>$district</option>";
                              }
                              ?>
                          </select>
                      </div>

                     <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input type="text" name="school_name" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label for="schoolid">School ID</label>
                        <input type="text" name="schoolid" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label for="school_email">School Email</label>
                        <input type="text" name="school_email" class="form-control" required>
                     </div>
                     <div class="form-group">
                        <label for="accessibility">Accessibility</label>
                        <select name="accessibility" class="form-control" required>
                           <option value="">Select</option>
                           <option value="Highly Accessible">Highly Accessible Schools</option>
                           <option value="Moderately Accessible">Moderately Accessible Schools</option>
                           <option value="Last Mile Schools">Last Mile Schools</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="facilities">Facilities</label>
                        <select name="facilities" class="form-control" required>
                           <option value="">Select</option>
                           <option value="Fully Equipped">Fully Equipped School</option>
                           <option value="Moderately Equipped">Moderately Equipped Schools</option>
                           <option value="Minimally Equipped">Minimally Equipped Schools</option>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="internet_connectivity">Internet Connectivity</label>
                        <select name="internet_connectivity" class="form-control" required>
                           <option value="">Select</option>
                           <option value="High speed internet">High speed internet</option>
                           <option value="Average speed internet">Average speed internet</option>
                           <option value="No internet">No internet</option>
                        </select>
                     </div>
                  </div>
                  <div class="modal-footer justify-content-end">
                     <button type="submit" class="btn btn-primary" name="addSchool">Save <i class="fas fa-save"></i></button>
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