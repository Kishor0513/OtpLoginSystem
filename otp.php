<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $otp = mysqli_real_escape_string($conn, $_POST['otp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Fetch the most recent OTP for the provided email
    $result = mysqli_query($conn, "SELECT * FROM otps WHERE email = '$email' AND otp = '$otp' ORDER BY created_at DESC LIMIT 1");

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $otp_time = strtotime($row['created_at']);
        $current_time = time();


        if (($current_time - $otp_time) <= 1) {
            header("Location: password.php?email=" . urldecode($email));
            exit();
        } else {
            echo "<script>alert('OTP has expired! Please request a new one.');</script>";
        }
    } else {
        echo "<script>alert('Invalid OTP! Please try again.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <!-- style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- font awesome link -->
    <script src="https://kit.fontawesome.com/9361e3694f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="otp-container">
        <form action="otp.php" method="post">
            <h3>OTP Confirmation</h3>
            <div class="inputBox">
                <input type="text" id="otp" name="otp" required>
                <span>Enter OTP</span>
                <i></i>
            </div>
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email']); ?>">
            <input type="submit" name="submit" value="Verify OTP">
            <div class="links">

                <a href="login.php?submit=true&email=<?php echo urlencode($_GET['email']); ?>">Resend</a>
                <a href="login.php">Go Back</a>
            </div>
        </form>
    </div>
</body>

</html>