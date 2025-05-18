<?php
include("config.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $checkQuery = "SELECT * FROM users WHERE email='$email'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $error = "Email already exists.";
        } else {
            $insertQuery = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";
            if (mysqli_query($conn, $insertQuery)) {
                $success = "Account created successfully! You can now log in.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - Job Recruitment System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- External CSS -->
    <link rel="stylesheet" href="signup.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="logo">
        <img src="job_logo.png" alt="Logo" />
    </div>
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="blog.php">Blog</a>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    </div>
</div>

<!-- Signup form container -->
<div class="login-container">
    <h2>Create Your Account</h2>
    <?php
        if (!empty($error)) echo "<div class='error'>$error</div>";
        if (!empty($success)) echo "<div class='success'>$success</div>";
    ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>

        <select name="role" required>
            <option value="" disabled selected>Select Role</option>
            <option value="job_seeker">Job Seeker</option>
            <option value="recruiter">Recruiter</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Sign Up</button>
    </form>
    <a class="login-link" href="login.php">Already have an account? Login</a>
</div>

</body>
</html>
