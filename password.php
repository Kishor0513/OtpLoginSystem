<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $pass = mysqli_real_escape_string($conn, md5($_POST['pass']));
    $email = mysqli_real_escape_string($conn, $email);

    // Check if the email and password are matched
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$pass' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Login successful! Redirecting....'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('Incorrect password, please try again');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Password</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="password-container">
        <form method="post" action="password.php">
            <h3>Enter Password</h3>
            <div class="inputBox">
                <input type="password" id="pass" name="pass" required>
                <span>Enter Password</span>
                <i></i>
            </div>
            <!-- Preserve email in hidden field -->
            <input type="hidden" name="email" value="<?php echo htmlspecialchars(isset($_POST['email']) ? $_POST['email'] : $_GET['email']); ?>">
            <input type="submit" name="submit" value="Login">
            <div class="links">
                <a href="register.php">Sign Up</a>
                <a href="login.php">Go Back</a>
            </div>
        </form>
    </div>
</body>

</html>