<?php
include('includes/database_connection.php');
session_start();
?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<?php
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
        <title>FAQ - <?php echo htmlspecialchars($SYS_name ?? 'CID Learning Analytics', ENT_QUOTES, 'UTF-8'); ?></title>
        <link rel="stylesheet" href="style/css/bootstrap.min.css">
        <script defer src="style/js/bootstrap.bundle.js"></script>
        <!-- Icon Font Stylesheet -->
        <link href="style/fontawesome/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style/myStyle.css">
        <link rel="stylesheet" href="style/page-refresh.css">
        <link rel="stylesheet" href="style/app-polish.css?v=5">
        <link rel="icon" type="image/jpg" href="images/<?php echo $SYS_logo; ?>">
        <style>
            .faq {
            margin-bottom: 20px;
            }
            .question {
            font-weight: bold;
            cursor: pointer;
            background-image: linear-gradient(to left, rgba(255, 255, 255, 0.5), #f9c21e);
            color: black;
            padding: 10px;
            border-radius:0.5vh;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            }
            .answer {
            display: none;
            padding: 10px;
            }
            .header4 {
            min-height: 50vh;
            width: 100%;
            background-image: linear-gradient(rgba(4, 9, 30, 0.7), rgba(4, 9, 30, 0.7)),
            url(images/<?php echo $CP_headerpicture; ?>);
            background-position: 25% 100%;
            background-size: cover;
            position: relative;
            }
            .map-responsive {
            overflow: hidden;
            padding-bottom: 56.25%;
            position: relative;
            height: 0;
            }
            .map-responsive iframe {
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            position: absolute;
            }
            .contact-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            }
            @media (min-width: 768px) {
            .contact-info {
            flex-direction: row;
            }
            .contact-info h5 {
            margin: 0 20px;
            }
            }
            .contact-col {
            flex-basis: 48%;
            margin-bottom: 30px;
            }
            .contact-col div {
            display: flex;
            align-items: center;
            margin-bottom: 40px;
            }
            .contact-col div .fa {
            font-size: 28px;
            color: #d78219;
            margin: 10px;
            margin-right: 30px;
            }
            .contact-col div p {
            padding: 0;
            }
            .contact-col div h5 {
            font-size: 20px;
            margin-bottom: 5px;
            color: #555;
            font-weight: 400;
            }
        </style>
        <style>
            .download-button {
            display: flex;
            align-items: center;
            }

            .icon-column {
                flex: 0 0 auto;
                margin-right: 10px;
            }

            .file-icon {
                font-size: 24px;
            }

            .file-icon.pdf::before {
                content: url('path/to/pdf-icon.png'); /* Replace with your PDF icon path */
            }

            .file-icon.docx::before {
                content: url('path/to/docx-icon.png'); /* Replace with your DOCX icon path */
            }

            .info-column {
                flex: 1 1 auto;
            }

            .file-name {
                font-weight: bold;
            }

            .file-size {
                font-size: 12px;
                color: #888;
            }

            .btn2 {
                margin: 5px;
                border-radius: 4px !important;
                width: 100%;
                border: 2px solid #3498db; /* Add your preferred border color */
                padding: 8px; /* Add padding for better visual appearance */
                box-sizing: border-box; /* Include padding and border in the element's total width and height */
                text-align: center;
                text-decoration: none;
                color: #3498db; /* Add your preferred text color */
                display: inline-block;
            }

            .file-icon-pdf,
            .file-icon-docx,
            .file-icon-png,
            .file-icon-jpg {
                width: 48px; /* Adjust the width as needed */
                height: 48px; /* Adjust the height as needed */
                background-size: cover;
                margin-top:0.3vh;
            }

            .file-icon-pdf {
                background-image: url('https://img.icons8.com/color/48/pdf.png');
            }

            .file-icon-docx {
                background-image: url('https://img.icons8.com/color/48/word.png');
            }

            .file-icon-png,
            .file-icon-jpg {
                background-image: url('https://img.icons8.com/plasticine/100/image.png');
            }


                .file-upload {
                    position: relative;
                    overflow: hidden;
                    display: inline-block;
                }

                .file-upload input[type=file] {
                    font-size: 100px;
                    position: absolute;
                    left: 0;
                    top: 0;
                    opacity: 0;
                }

                .file-upload-label {
                    display: block;
                    padding: 10px 20px;
                    background-color: #3498db;
                    color: #fff;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    font-size: 16px;
                    transition: background-color 0.3s;
                }

                .file-upload-label:hover {
                    background-color: #2980b9;
                }

                .file-name {
                    margin-top: 10px;
                    font-size: 14px;
                }
        </style>
    </head>
    <?php
        include 'includes/modals.php';
    ?>
    <body class="faq-page">
        <?php
            include('includes/navbarTop.php');
            include('includes/public-navigation.php');
        ?>
        <section class="header4 public-page-hero">
            <div class="text-box">
                <h1>Frequently Asked Questions</h1>
                <p>Find guidance on using the learning analytics platform and getting support.</p>
            </div>
        </section>
        <div class="container pt-5" style="margin-bottom:auto;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                    <div class="row">
                        <?php
                        $systemconfig = mysqli_query($DB, "SELECT * FROM faq");
                        
                        if (mysqli_num_rows($systemconfig) > 0) { 
                            while ($row = mysqli_fetch_assoc($systemconfig)) { 
                        ?>
                                <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6">
                                    <div class="faq">
                                        <div class="question" style="color:black;"><?php echo $row['question']; ?></div>
                                        <div class="answer"><?php echo $row['answer']; ?>
                                        <?php 
                                            if (stripos($row['question'], 'download') !== false || 
                                                stripos($row['answer'], 'Download') !== false) { ?>
                                                    <br>
                                                                        
                                                    <!-- Add Download Button Container (initially hidden) -->
                                                    <div id="downloadExcelContainer" class="text-center mb-4" style="display:block;">
                                                        <a id="downloadExcelBtn" class="btn btn-primary" target="_blank" href="https://depedph-my.sharepoint.com/:f:/g/personal/lrms_abra_deped_gov_ph/EhT7yKeFvh5OoIWjV1K__dcBXyze5vY3bh4gcVsQMB_H7Q?e=43DrmN">
                                                            <i class="fas fa-file-excel"></i> Download Templates
                                                        </a>
                                                    </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                        <?php 
                            } 
                        } 
                        
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Optional: Add Font Awesome for the download icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
              $('.question').click(function(){
                $(this).next('.answer').slideToggle();
              });
            });
        </script>
        <br><br>
        <br><br>
        <br><br>
        <?php
            include('footer.php');
            ?>
    </body>
</html>