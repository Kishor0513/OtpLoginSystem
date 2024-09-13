<?php
@include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendOTP($email, $otp)
{
    $mail = new PHPMailer(true);

    try {
        //Message sending setting using phpmailer 
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'kishorc2000@gmail.com';
        $mail->Password   = 'gkct mujl rygp ygsk';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('work.kishorc2000@gmail.com', 'Kishor');
        $mail->addAddress($email);

        // Message which will be sent to email
        $mail->isHTML(true);
        $mail->Subject = 'OTP Code Verification';
        $mail->Body    = "Your OTP code is <b>$otp</b>. It is valid for 2 minutes.";
        $mail->AltBody = "Your OTP code is $otp. It is valid for 2 minutes.";

        $mail->send();
        echo "<script>alert('OTP has been sent to your email.');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: " . $mail->ErrorInfo . "');</script>";
    }
}

if (isset($_POST['submit'])) {
    // Retrieve and sanitize the email address
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
        exit();
    }

    // Check if the email is registered
    $check_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' LIMIT 1");

    if (mysqli_num_rows($check_email) > 0) {
        $otp = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'), 0, 6);

        // Save the OTP to the database
        $query = mysqli_query($conn, "INSERT INTO otps (email, otp, created_at) VALUES ('$email', '$otp', NOW())");

        // Send OTP to email
        sendOTP($email, $otp);

        header("Location: otp.php?email=" . urlencode($email));
        exit();
    } else {
        echo "<script>alert('Email is not registered!');</script>";
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Signup</title>
    <!-- style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- font awesome link -->
    <script src="https://kit.fontawesome.com/9361e3694f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login-container">
        <form method="post" action="login.php" id="loginForm" onsubmit="return validate();">
            <h3>Sign In</h3>
            <div class="inputBox">
                <input type="email" name="email" id="email" required>
                <span>Email</span>
                <i></i>
            </div>

            <input type="submit" name="submit" value="Get OTP">

            <div class="links">
                <a href="#">Forgot Password</a>
                <a href="register.php">Sign Up</a>
            </div>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>