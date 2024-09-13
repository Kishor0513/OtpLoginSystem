<?php
@include 'config.php';
if (isset($_POST['submit'])) {

    
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpass']));
    $created_at = date('Y-m-d H:i:s'); 

    if ($pass !== $cpass) {
        echo "<script>alert('Passwords do not match');</script>";
    } else {
        
        $check_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

        if (mysqli_num_rows($check_email) > 0) {
            echo "<script>alert('Email already registered!');</script>";
        } else {
            
            $insert = "INSERT INTO users(name, email, password, created_at) VALUES('$name', '$email', '$pass', '$created_at')";

            if (mysqli_query($conn, $insert)) {
                echo "<script>alert('Registration successful!');</script>";
            } else {
                
                echo"<script>alert('Connection Error);</script>";
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Signup</title>
    <!-- style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- font awesome link -->
    <script src="https://kit.fontawesome.com/9361e3694f.js" crossorigin="anonymous"></script>
</head>

<body>

    <div class="register-container">
        <form method="post" action="register.php" onsubmit="return validateForm(event);" >
            <h3>Sign Up</h3>
            <div class="inputBox">
                <input type="text" name="name" id="name" required>
                <span>Username</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="email" name="email" id="email" required>
                <span>Email</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="pass" id="pass" required>
                <span>Enter Password</span>
                <i></i>
            </div>
            <div class="inputBox">
                <input type="password" name="cpass" id="cpass" required>
                <span>Confirm Password</span>
                <i></i>
            </div>
            <input type="submit" name="submit" value="Register">
            <div class="links">
                <a href="login.php">Already have an account? Sign In</a>
            </div>
        </form>
    </div>

    <script src="assets/js/script.js"></script>
</body>

</html>