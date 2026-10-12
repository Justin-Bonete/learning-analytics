<?php

    $grade_level_global = $_SESSION['grade_level'];


    require_once('../includes/database_connection.php'); 
?><script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-blue elevation-4 role-sidebar">
    <!-- Brand Logo -->
    <a href="dashboard.php" class="brand-link">
        <img src="../images/abra-gov-seal.png" alt="adminLogo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-bold">TEACHER PANEL</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image mt-2">

                        <img src="../assets/uploads/default_profile.png" alt="Circle Image" class="circle-img">
            </div>
            <div class="info">
                <a href="#" data-toggle="modal" data-target="#editAdminProfile" class="d-block"><?php echo $_SESSION['school_name']; ?></a>
                <small class="text-light d-block"><?php echo $_SESSION['position']; ?></small>
                <small class="text-light d-block"><?php echo $_SESSION['grade_level']; ?></small>
            </div>
        </div>
        <?php } ?>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-header">DASHBOARD</li>
                <li class="nav-item ">
                    <a href="dashboard.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'dashboard.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                <li class="nav-header">MANAGE LEARNERS</li>
                <!--
                <li class="nav-item">
                    <a href="manage_school.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_school.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            School List
                        </p>
                    </a>
                </li>
                    -->
               
                <?php if (preg_match('/^Grade ([1-9]|10)$/', $_SESSION['grade_level'])) { ?>
                <li class="nav-item">
                    <a href="manage_student.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_student.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Learners List
                        </p>
                    </a>
                </li>
                <?php } ?>
                <?php if($_SESSION['grade_level'] == 'Grade 11' || $_SESSION['grade_level'] == 'Grade 12'){ ?>
                <li class="nav-item">
                    <a href="manage_shs.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_shs.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Senior High School
                        </p>
                    </a>
                </li>
                <?php } ?>
                <?php if($_SESSION['grade_level'] == 'Kinder'){ ?>
                <li class="nav-item">
                    <a href="manage_kinder.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_kinder.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Kinder
                        </p>
                    </a>
                </li>
                <?php } ?>
                <?php if($_SESSION['grade_level'] != 'Grade 11' && $_SESSION['grade_level'] != 'Grade 12'){ ?>
                <li class="nav-header">MANAGE SCORES</li>
                <li class="nav-item">
                    <a href="manage_scores.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_scores.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Learners Scores
                        </p>
                    </a>
                </li>
                <?php } ?>
                <li class="nav-header">MANAGE GRADES</li>
                <?php if (preg_match('/^Grade ([1-9]|10)$/', $_SESSION['grade_level'])) { ?>
                <li class="nav-item">
                    <a href="manage_grades.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_grades.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Learners Grades
                        </p>
                    </a>
                </li>
                <?php } ?>
                <?php if($_SESSION['grade_level'] == 'Grade 11'){ ?>
                <li class="nav-item">
                    <a href="manage_grades11.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_grades11.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Grade 11
                        </p>
                    </a>
                </li>
                <?php } ?>
                
                <?php if($_SESSION['grade_level'] == 'Grade 12'){ ?>
                <li class="nav-item">
                    <a href="manage_grades12.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_grades12.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Grade 12
                        </p>
                    </a>
                </li>
                <?php } ?>
                
                <?php if($_SESSION['grade_level'] != 'Grade 11' && $_SESSION['grade_level'] != 'Grade 12'){ ?>

                <li class="nav-header">MANAGE PROCESSED DATA</li>

                <li class="nav-item">
                    <a href="manage_mps.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_mps.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-percentage"></i>
                        <p>
                            Mean Percentage Scores
                        </p>
                    </a>
                </li>
                <?php } ?>

                <li class="nav-header">LEVEL OF PROFICIENCY</li>
                
                
                <?php if($_SESSION['grade_level'] != 'Grade 11' && $_SESSION['grade_level'] != 'Grade 12'){ ?>
                    <?php 
                    if (preg_match('/Grade (\d+)\b/', $_SESSION['grade_level'], $matches)) {  
                        $gradeNumber = $matches[1]; 
                    ?>
                <li class="nav-item">
                    <a href="manage_lop.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_lop.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-level-up-alt"></i>
                        <p>
                            Grade <?php echo $gradeNumber; ?> LOP
                        </p>
                    </a>
                </li>
                <?php } ?>
                <?php } ?>
              
                
                <?php if($_SESSION['grade_level'] == 'Grade 11'){ ?>
                <li class="nav-item">
                    <a href="manage_lopgrade11.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_lopgrade11.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-level-up-alt"></i>
                        <p>
                            Grade 11 LOP
                        </p>
                    </a>
                </li>
                <?php } ?>
                
                <?php if($_SESSION['grade_level'] == 'Grade 12'){ ?>
                <li class="nav-item">
                    <a href="manage_lopgrade12.php" class="nav-link <?php if (basename(htmlspecialchars($_SERVER["PHP_SELF"], ENT_QUOTES, "utf-8")) == 'manage_lopgrade12.php')
                        echo 'active'; ?>">
                        <i class="nav-icon fas fa-level-up-alt"></i>
                        <p>
                            Grade 12 LOP
                        </p>
                    </a>
                </li>
                <?php } ?>


                <li class="nav-header">MANAGE UPLOADS</li>
                <style>
                    .custommodal {
                        display: none;
                        position: fixed;
                        z-index: 1050;
                        left: 0;
                        top: 0;
                        width: 100%;
                        height: 100%;
                        overflow: hidden;
                        background-color: rgba(0, 0, 0, 0.5);
                        backdrop-filter: blur(5px);
                    }

                    .custommodal.show {
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }

                    .custommodal .modal-dialog {
                        max-width: 500px;
                        width: 90%;
                        background: white;
                        border-radius: 10px;
                        overflow: hidden;
                        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
                        animation: fadeIn 0.3s ease-in-out;
                    }

                    .custommodal .modal-header {
                        background: #007bff;
                        color: white;
                        padding: 15px;
                        font-size: 18px;
                        font-weight: bold;
                    }

                    .custommodal .modal-body {
                        padding: 20px;
                    }

                    .custommodal .modal-footer {
                        padding: 10px;
                        text-align: right;
                    }

                    .custommodal .close {
                        color: white;
                        font-size: 20px;
                        opacity: 0.8;
                    }

                    .custommodal .drop-zone {
                        border: 2px dashed #007bff;
                        padding: 20px;
                        text-align: center;
                        cursor: pointer;
                        border-radius: 5px;
                        background: #f8f9fa;
                    }

                    .custommodal .drop-zone__input {
                        display: none;
                    }

                    /* Fade-in animation */
                    @keyframes fadeIn {
                        from {
                            opacity: 0;
                            transform: translateY(-10px);
                        }
                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                                    </style>
                    <!-- Button to Open Modal -->
                    <button type="button" class="btn btn-primary" onclick="openModal('uploadModal')" style="margin-bottom:1vh;">
                        Upload Learners Score
                    </button>

                    <!-- Custom Modal -->
                    <div class="custommodal" id="uploadModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Upload CSV File</h5>
                                    <button type="button" class="close" onclick="closeModal('uploadModal')">
                                        <span>&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
               <!-- Instruction Panel -->
               <div style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 5px; padding: 12px; margin-bottom: 15px; font-size: 0.9rem; color: #333;">
                  <strong>Instructions:</strong>
                  <ul style="margin: 5px 0 0 18px; padding: 0;">
                    <li>Please upload the CSV file containing learners' scores.</li>
                    <li>Ensure the file matches the required template format exactly.</li>
                    <li>Select the correct school year that corresponds to the data in your <br>CSV file.</li>
                    <li>The date should reflect when the file is being uploaded.</li>
                  </ul>
               </div>


                                    <form id="uploadForm" enctype="multipart/form-data">
               <!-- Add Date Selection -->
               <div class="form-group">
                  <label for="scoreDate">Select Date (School Year):</label>
                  <input type="date" class="form-control" id="scoreDate" name="scoreDate" required>
               </div>
                                        <div class="drop-zone" id="drop-zone">
                                            <span class="drop-zone__prompt">Drag & drop your CSV file here or click to upload</span>
                                            <input type="file" name="csv_file" id="csv_file" class="drop-zone__input" accept=".csv" required>
                                        </div>
                                        <br>
                                        <button type="submit" class="btn btn-success btn-block">Upload & Process</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- JavaScript to Handle Modal -->
                    <script>
                        function openModal(modalId) {
                            document.getElementById(modalId).classList.add("show");
                        }

                        function closeModal(modalId) {
                            document.getElementById(modalId).classList.remove("show");
                        }
                    </script>
                    <script>
                        document.getElementById('drop-zone').addEventListener('click', function () {
                            document.getElementById('csv_file').click(); // Trigger file input click
                        });
                        document.getElementById('csv_file').addEventListener('change', function (event) {
                            const file = event.target.files[0]; // Get the selected file
                            const dropZone = document.getElementById('drop-zone');

                            if (file) {
                                dropZone.querySelector('.drop-zone__prompt').textContent = file.name; // Update label
                            }
                        });

                        document.getElementById('drop-zone').addEventListener('dragover', function (event) {
                            event.preventDefault();
                            this.classList.add('drag-over');
                        });

                        document.getElementById('drop-zone').addEventListener('dragleave', function () {
                            this.classList.remove('drag-over');
                        });

                        document.getElementById('drop-zone').addEventListener('drop', function (event) {
                            event.preventDefault();
                            this.classList.remove('drag-over');

                            const fileInput = document.getElementById('csv_file');
                            const file = event.dataTransfer.files[0];

                            if (file) {
                                fileInput.files = event.dataTransfer.files; // Assign file to input
                                this.querySelector('.drop-zone__prompt').textContent = file.name; // Update label
                            }
                        });

                        document.getElementById('uploadForm').addEventListener('submit', function (e) {
                            e.preventDefault();
                            var formData = new FormData(this);

                            fetch('upload_learner_score.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.text())
                            .then(data => {
                                console.log(data);
                                
                                // SweetAlert success message
                                Swal.fire({
                                    title: "Success!",
                                    text: "CSV file uploaded and processed successfully.",
                                    icon: "success",
                                    confirmButtonText: "OK"
                                }).then(() => location.reload()); // Reload after confirmation
                            })
                            .catch(error => {
                                console.error('Error:', error);

                                // SweetAlert error message
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed to upload CSV file. Please try again.",
                                    icon: "error",
                                    confirmButtonText: "OK"
                                });
                            });
                        });
                    </script>

                    <!-- Button to Open Modal -->
                    <button type="button" class="btn btn-primary" onclick="openModal('uploadGradeModal')" style="margin-bottom:1vh;">
                        Upload Learners Grade
                    </button>

                  <!-- Custom Modal -->
<div class="custommodal" id="uploadGradeModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload CSV File for Learners Grade</h5>
                <button type="button" class="close" onclick="closeModal('uploadGradeModal')">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadGradeForm" enctype="multipart/form-data"><!-- Instruction Panel -->
<div style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 5px; padding: 12px; margin-bottom: 15px; font-size: 0.9rem; color: #333;">
   <strong>Instructions:</strong>
   <ul style="margin: 5px 0 0 18px; padding: 0;">
     <li>Please upload the CSV file containing learners' scores.</li>
     <li>Ensure the file matches the required template format exactly.</li>
     <li>Select the correct school year that corresponds to the data in your <br>CSV file.</li>
     <li>Select the corresponding grade level of the CSV file.</li>
     <li>Make sure the contents of the CSV file correspond to the selected <br>grade level.</li>
     <li>The date should reflect when the file is being uploaded.</li>
   </ul>
</div>


               <!-- Add Date Selection -->
               <div class="form-group">
                  <label for="gradeDate">Select Date:</label>
                  <input type="date" class="form-control" id="gradeDate" name="gradeDate" required>
               </div>
                    <!-- Selection Dropdown -->
                    <div class="form-group">
                        <label for="gradeLevel">Select Grade Level:</label>
                        <select id="gradeLevel" class="form-control">
                <?php if($_SESSION['grade_level'] == 'Kinder'){ ?>
                            <option value="kinder">Kinder</option>
                            <?php } ?>
                <?php if (preg_match('/^Grade ([1-9]|10)$/', $_SESSION['grade_level'])) { ?>
                            <option value="grade1to10">Grade 1 to 10</option>
                <?php } ?>
                <?php if($_SESSION['grade_level'] == 'Grade 11' || $_SESSION['grade_level'] == 'Grade 12'){ ?>
                            <option value="shs">Senior High School</option> 
                            <?php } ?>
                        </select>
                    </div>

                    <!-- Drag & Drop Upload -->
                    <div class="drop-zone" id="drop-zone-grade">
                        <span class="drop-zone__prompt">Drag & drop your CSV file here or click to upload</span>
                        <input type="file" name="csv_file" id="csv_file_grade" class="drop-zone__input" accept=".csv" required>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block">Upload & Process</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Modal and Form Submission -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.add("show");
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove("show");
    }

    document.getElementById('drop-zone-grade').addEventListener('click', function () {
        document.getElementById('csv_file_grade').click(); // Trigger file input click
    });

    document.getElementById('csv_file_grade').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const dropZone = document.getElementById('drop-zone-grade');

        if (file) {
            dropZone.querySelector('.drop-zone__prompt').textContent = file.name;
        }
    });

    document.getElementById('drop-zone-grade').addEventListener('dragover', function (event) {
        event.preventDefault();
        this.classList.add('drag-over');
    });

    document.getElementById('drop-zone-grade').addEventListener('dragleave', function () {
        this.classList.remove('drag-over');
    });

    document.getElementById('drop-zone-grade').addEventListener('drop', function (event) {
        event.preventDefault();
        this.classList.remove('drag-over');

        const fileInput = document.getElementById('csv_file_grade');
        const file = event.dataTransfer.files[0];

        if (file) {
            fileInput.files = event.dataTransfer.files;
            this.querySelector('.drop-zone__prompt').textContent = file.name;
        }
    });

    document.getElementById('uploadGradeForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);

        // Determine the correct endpoint based on selection
        var gradeLevel = document.getElementById('gradeLevel').value;
        var actionURL = (gradeLevel === 'shs') ? 'upload_learner_grade_shs.php' : 'upload_learner_grade.php';

        fetch(actionURL, {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log(data);
            Swal.fire({
                title: "Success!",
                text: "CSV file uploaded and processed successfully.",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => location.reload()); 
            
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: "Error!",
                text: "Failed to upload CSV file. Please try again.",
                icon: "error",
                confirmButtonText: "OK"
            });
        });
    });
</script>


                    <!-- Upload Learners Button and Modal -->
<button type="button" class="btn btn-primary" onclick="openModal('uploadLearnersModal')" style="margin-bottom:1vh;">
    Upload Learners
</button>

<div class="custommodal" id="uploadLearnersModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload CSV File for Learners</h5>
                <button type="button" class="close" onclick="closeModal('uploadLearnersModal')">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadLearnersForm" enctype="multipart/form-data"><div style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 5px; padding: 12px; margin-bottom: 15px; font-size: 0.9rem; color: #333;">
  <strong>Instructions for Uploading Learners Profile:</strong>
  <ul style="margin: 5px 0 0 18px; padding: 0;">
    <li>Please upload the CSV file containing learner profiles.</li>
    <li>Select the appropriate grade level that matches <br>the learners in your CSV file.</li>
    <li>Make sure the contents of the CSV file correspond <br>exactly to the selected grade level.</li>
    <li>Ensure the CSV file follows the required template <br>format for learner profiles.</li>
  </ul>
</div>

                    <div class="form-group">
                        <label for="grade_selection">Select Grade Level:</label>
                        <select id="grade_selection" class="form-control">
                <?php if($_SESSION['grade_level'] == 'Kinder'){ ?>
                            <option value="kinder">Kinder</option>
                            <?php } ?>
                <?php if (preg_match('/^Grade ([1-9]|10)$/', $_SESSION['grade_level'])) { ?>
                            <option value="grade1to10">Grade 1 to 10</option>
                <?php } ?>
                <?php if($_SESSION['grade_level'] == 'Grade 11' || $_SESSION['grade_level'] == 'Grade 12'){ ?>
                            <option value="shs">Senior High School</option> 
                            <?php } ?>
                        </select>
                    </div>

                    <div class="drop-zone" id="drop-zone-learners">
                        <span class="drop-zone__prompt">Drag & drop your CSV file here or click to upload</span>
                        <input type="file" name="csv_file" id="csv_file_learners" class="drop-zone__input" accept=".csv" required>
                    </div>
                    
                    <br>
                    <button type="submit" class="btn btn-success btn-block">Upload & Process</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Upload Teachers Button and Modal -->
<button type="button" class="btn btn-primary" onclick="openModal('uploadTeachersModal')" style="display:none;">
    Upload Teachers
</button>

<div class="custommodal" id="uploadTeachersModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload CSV File for Teachers</h5>
                <button type="button" class="close" onclick="closeModal('uploadTeachersModal')">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadTeachersForm" enctype="multipart/form-data"><div style="background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 5px; padding: 12px; margin-bottom: 15px; font-size: 0.9rem; color: #333;">
  <strong>Instructions for Uploading Teachers Profile:</strong>
  <ul style="margin: 5px 0 0 18px; padding: 0;">
    <li>Please upload the CSV file containing teachers' profiles.</li>
    <li>Make sure the data corresponds to the teachers' <br>actual profiles and positions.</li>
    <li>The CSV file must follow the prescribed <br>template format exactly.</li>
  </ul>
</div>
                    <div class="drop-zone" id="drop-zone-teachers">
                        <span class="drop-zone__prompt">Drag & drop your CSV file here or click to upload</span>
                        <input type="file" name="csv_file" id="csv_file_teachers" class="drop-zone__input" accept=".csv">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-success btn-block">Upload & Process</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to Handle Modals and Uploads -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.add("show");
    }
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove("show");
    }

    function setupDragAndDrop(dropZoneId, inputId) {
        let dropZone = document.getElementById(dropZoneId);
        let inputFile = document.getElementById(inputId);
        
        dropZone.addEventListener('click', () => inputFile.click());
        inputFile.addEventListener('change', event => {
            let file = event.target.files[0];
            if (file) dropZone.querySelector('.drop-zone__prompt').textContent = file.name;
        });
        dropZone.addEventListener('dragover', event => {
            event.preventDefault();
            dropZone.classList.add('drag-over');
        });
        dropZone.addEventListener('dragleave', () => dropZone.classList.remove('drag-over'));
        dropZone.addEventListener('drop', event => {
            event.preventDefault();
            dropZone.classList.remove('drag-over');
            let file = event.dataTransfer.files[0];
            if (file) {
                inputFile.files = event.dataTransfer.files;
                dropZone.querySelector('.drop-zone__prompt').textContent = file.name;
            }
        });
    }

    setupDragAndDrop('drop-zone-learners', 'csv_file_learners');
    setupDragAndDrop('drop-zone-teachers', 'csv_file_teachers');

    function setupFormSubmission(formId, uploadUrl) {
        document.getElementById(formId).addEventListener('submit', function (e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch(uploadUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                Swal.fire({
                    title: "Success!",
                    text: "CSV file uploaded and processed successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => location.reload());
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    title: "Error!",
                    text: "Failed to upload CSV file. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
        });
    }

    document.getElementById('uploadLearnersForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Prevent default form submission
        
        let selectedGrade = document.getElementById('grade_selection').value;
        let uploadUrl = (selectedGrade === "Senior High School") ? 'upload_senior_learners.php' : 'upload_learners.php';

        setupFormSubmission('uploadLearnersForm', uploadUrl);
    });
    setupFormSubmission('uploadTeachersForm', 'upload_teachers.php');
</script>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>