<?php
// index.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Job Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- External CSS -->
    <link rel="stylesheet" href="index.css" />
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

    <!-- Hero Section -->
    <div class="home_cont">
        <div class="main_descrip">
            <h1>Explore Your Dream</h1>
            <p>Find the job that suits you the best</p>
            <a href="login.php"><button>Get Started</button></a>
        </div>
    </div>

    <!-- About Section -->
    <div class="about_cont">
        <img src="padu.jpg" alt="Career Path" />
        <div class="about_descript">
            <h2>About Our Job Portal</h2>
            <p>We help job seekers and recruiters connect in a seamless way using modern tools and smart filtering.</p>
            <a href="about.php"><button>Learn More</button></a>
        </div>
    </div>

    <!-- Questions Section -->
    <div class="questions_cont">
        <div class="questions">
            <h2>Have Questions?</h2>
            <p>Feel free to contact us for any job or recruiter related queries.</p>
            <a href="contact.php"><button>Contact Us</button></a>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <script src="index.js"></script>

</body>
</html>
