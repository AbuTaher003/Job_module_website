<?php
// session_start(); // Optional if needed
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>About Us</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
    integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="home.css" />
  <link rel="stylesheet" href="about.css" />
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div class="logo">
      <img src="job_logo.png" alt="Logo" />
    </div>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="about.php" class="active">About</a>
      <a href="blog.php">Blog</a>
      <a href="login.php">Login</a>
      <a href="signup.php">Signup</a>
    </div>
  </div>

  <section class="about_cont">
    <img src="about_us.jpg" alt="About Us" />
    <div class="about_descript">
      <h2 class="section-header">Why Choose Us?</h2>
      <p>
        Welcome to <strong>Job Portal</strong>, your reliable partner in finding the perfect job or employee. 
        With a modern, user-friendly platform, we bring employers and job seekers together seamlessly.
      </p>
      <p>
        Our dedicated team constantly curates verified job listings, provides personalized recommendations, and supports you throughout your hiring or job-seeking journey.
      </p>
      <p>
        Join thousands of satisfied users and experience the ease of matching talent to opportunity with us.
      </p>
    </div>
  </section>

  <section class="questions_cont">
    <div class="questions">
      <h2 class="section-header">Have Any Queries?</h2>
      <p>
        We're here to help! If you have questions or need assistance, our team is ready to support you every step of the way.
      </p>
      <button class="product_btn" onclick="window.location.href='contact.php'">Contact Us</button>
    </div>
  </section>

  <?php include 'footer.php'; ?>

  <script src="https://kit.fontawesome.com/eedbcd0c96.js" crossorigin="anonymous"></script>
  <script src="about.js"></script>
</body>
</html>
