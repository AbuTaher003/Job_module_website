<?php
session_start();
include("config.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    $query = "SELECT * FROM users WHERE email='$email' AND role='$role'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            if ($role == "job_seeker") {
                header("Location: job_seeker_dashboard.php");
            } elseif ($role == "recruiter") {
                header("Location: recruiter_dashboard.php");
            } elseif ($role == "admin") {
                header("Location: admin_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - Job Recruitment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="login.css" />
</head>
<body>
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

  <div class="login-container">
    <h2>Login to Your Account</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email Address" required />

      <div class="password-container">
        <input type="password" id="password" name="password" placeholder="Password" required />
        <span class="toggle-password" onclick="togglePassword()">👁️</span>
      </div>

      <select name="role" required>
        <option value="" disabled selected>Select Role</option>
        <option value="job_seeker">Job Seeker</option>
        <option value="recruiter">Recruiter</option>
        <option value="admin">Admin</option>
      </select>

      <button type="submit">Login</button>
    </form>
    <a class="login-link" href="signup.php">Don't have an account? Sign up</a>
  </div>

  <footer>
    <p>&copy; 2025 Job Recruitment System. All rights reserved.</p>
  </footer>

  <script src="login.js"></script>
</body>
</html>
