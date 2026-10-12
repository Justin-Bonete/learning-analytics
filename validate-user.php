<?php 
include('includes/database_connection.php');

        $email = $_REQUEST['email'];
        $update = mysqli_query($DB, "UPDATE schools SET email_status='Active' WHERE email='$email'");


    if($update) {
        echo '<script>alert("Account has been verified successfully, please wait for the administrator approval before logging in your account. We will notify you shortly thru email."); window.close();</script>';
    } else {
        echo '<script>alert("Something went wrong while saving the information."); window.close();</script>';
    }
?>