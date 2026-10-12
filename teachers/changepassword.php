<?php
session_start();
include('includes/header.php');
include('includes/topbar.php');
include('includes/sidebar.php');
include('includes/modals.php');

// Include PHPMailer only once at top
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../admin/src/Exception.php';
require '../admin/src/PHPMailer.php';
require '../admin/src/SMTP.php';

$message = '';
$otp_display = '';
$otp_verified = $_SESSION['otp_verified'] ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode'] ?? '';

    if ($mode === 'send_otp') {
        $email = $_SESSION['email'] ?? '';
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message = "❌ Invalid email format.";
        } else {
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_email'] = $email;
            $_SESSION['otp_verified'] = false; // Reset verified flag

            // Email setup (your PHPMailer code here) ...

            $mail = new PHPMailer();
            try {
                // Your PHPMailer setup...
                $mail->isSMTP();
                $mail->Mailer = "smtp";
                $mail->SMTPDebug = false;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;
                $mail->Host = "smtp.gmail.com";
                $mail->Username = "rjq.software.tester@gmail.com";
                $mail->Password = "nhnavzxoojdmzwax";
                $mail->isHTML(true);
                $mail->addAddress($email);
                $mail->setFrom("rjq.software.tester@gmail.com", "Your System");
                $mail->Subject = "Your OTP Code";
                $mail->Body = '
                <html>
                  <body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
                    <div style="max-width: 600px; margin: auto; background: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                      <h2 style="color: #2c3e50; text-align: center;">Your One-Time Password (OTP)</h2>
                      <p style="font-size: 16px; color: #333;">Dear User,</p>
                      <p style="font-size: 16px; color: #333;">
                        We received a request to reset your password. Please use the OTP below to verify your identity and proceed with changing your password.
                      </p>
                      <div style="text-align: center; margin: 30px 0;">
                        <span style="font-size: 28px; font-weight: bold; color: #2980b9; letter-spacing: 6px;">' . $otp . '</span>
                      </div>
                      <p style="font-size: 14px; color: #666;">
                        This OTP is valid for the next 10 minutes. If you did not request a password reset, please ignore this email or contact support.
                      </p>
                      <br>
                      <p style="font-size: 16px; color: #333;">Best regards,<br><strong>Your System Team</strong></p>
                    </div>
                  </body>
                </html>
                ';

                if ($mail->send()) {
                    $message = "✅ OTP sent to <strong>$email</strong>.";
                    // Display OTP on page for testing (remove this in production!)
                    $otp_display = "<p><strong>OTP (for testing):</strong> $otp</p>";
                } else {
                    $message = "❌ Failed to send OTP.";
                }
            } catch (Exception $e) {
                $message = "❌ Mail error: " . $mail->ErrorInfo;
            }
        }
    } elseif ($mode === 'verify_otp') {
        $entered_otp = $_POST['otp'] ?? '';
        if (isset($_SESSION['otp']) && $entered_otp == $_SESSION['otp']) {
            $_SESSION['otp_verified'] = true;
            $otp_verified = true;
            $message = "✅ OTP verified. You can now reset your password.";
        } else {
            $message = "❌ Invalid OTP.";
        }
    } elseif ($mode === 'change_password') {
        if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
            $message = "❌ OTP not verified.";
        } else {
            $newpass = $_POST['new_password'] ?? '';
            $confirmpass = $_POST['confirm_password'] ?? '';
            $email = $_SESSION['otp_email'] ?? '';

            if ($newpass !== $confirmpass) {
                $message = "❌ Passwords do not match.";
            } elseif (strlen($newpass) < 6) {
                $message = "❌ Password too short (min 6 characters).";
            } else {
                $hashed = md5($newpass);
                $query = "UPDATE teachers_profiling SET password='$hashed' WHERE email='$email'";
                $run = mysqli_query($conn, $query);

                if ($run) {
                    $message = "✅ Password changed successfully.";
                    session_unset(); // Clear OTP and related session data
                } else {
                    $message = "❌ Failed to update password.";
                }
            }
        }
    }
}
?>
<style>
    .bg-blue {
        background-color: #d0e4a0 !important;
        color: black !important;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"><h1 class="m-0">Change Password</h1></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
            <?php if ($message): ?>
                <div class="alert alert-info"><?= $message ?></div>
            <?php endif; ?>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid" style="width:50%;">
            
            <!-- Step 1: Enter Email -->
            <form method="POST" <?= $otp_verified ? 'style="display:none;"' : '' ?>>
                <input type="hidden" name="mode" value="send_otp">
                <div class="form-group">
                    <label>Email Address:</label>
                    <input type="email" name="email" class="form-control" required placeholder="Enter your email" value="<?php echo $_SESSION['email']; ?>" disabled>
                </div>
                <button type="submit" class="btn btn-primary">Send OTP</button>
            <hr>
            </form>

            <!-- Show OTP on page (for testing!) -->
            <?= $otp_display ?>


            <!-- Step 2: Enter OTP -->
            <form method="POST" <?= ($otp_verified || empty($_SESSION['otp'])) ? 'style="display:none;"' : '' ?>>
                <input type="hidden" name="mode" value="verify_otp">
                <div class="form-group">
                    <label>Enter OTP:</label>
                    <input type="text" name="otp" class="form-control" required placeholder="Enter 6-digit OTP">
                </div>
                <button type="submit" class="btn btn-success">Verify OTP</button>
            <hr>
            </form>


            <!-- Step 3: Change Password -->
            <form method="POST" <?= !$otp_verified ? 'style="display:none;"' : '' ?>>
                <input type="hidden" name="mode" value="change_password">
                <div class="form-group">
                    <label>New Password:</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Confirm Password:</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-warning">Change Password</button>
            </form>

        </div>
    </section>
</div>

<script type="text/javascript">
    // Disable back button cache
    window.onbeforeunload = function () {
        location.reload(true);
    };
</script>

<?php include('includes/footer.php'); ?>
