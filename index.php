<?php
session_start();
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

        header('Location: about.php');
        exit();
     


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Home - <?php echo $SYS_name; ?></title>
    <link rel="stylesheet" href="style/css/bootstrap.min.css">
    <script defer src="style/js/bootstrap.bundle.js"></script>
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/jpg" href="images/<?php echo $SYS_logo; ?>">
    <link rel="stylesheet" href="style/myStyle.css">
</head>
<?php
include 'includes/modals.php';
?>
<body>
    <?php
    include('includes/navbarTop.php');
    ?>
    <style>
    .header1 {
      min-height: 100vh;
      width: 100%;background-image: linear-gradient(rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.3)),
    url(images/<?php echo $SYS_background; ?>);

      background-position: center;
      background-size: cover;
      position: relative;
    }
    </style>
    <section class="header1">
        <?php
            include('includes/navbarBottom.php');
            include('js/JSFunctions.php');
        ?>
        <div class="text-box">

<div style="text-align: center;">
    <img src="images/cidlogo1.png" alt="Logo" style="width: 35vh; height: auto;">
</div>
                <?php if(isset($_SESSION['logged']) && $_SESSION['logged'] == 'True') { ?>
                              <?php }else{ ?>
                              <?php } ?>

        </div>
    </section>

    <?php
    include('footer.php');

    ?>
</body>
</html>