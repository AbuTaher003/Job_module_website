<?php
// blog.php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Blog - Job Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    
    <!-- External CSS -->
    <link rel="stylesheet" href="blog.css" />
</head>
<body>
    <!-- Navbar -->
    <div class="navbar">
        <div class="logo">
            <a href="index.php"><img src="job_logo.png" alt="Logo" /></a>
        </div>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="blog.php">Blog</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
        </div>
    </div>

    <!-- Blog Content -->
    <div class="container">
        <div class="blog-post">
            <h2>Top 5 CV Mistakes to Avoid</h2>
            <p>Creating a powerful CV is the first step in landing your dream job. Learn the top common mistakes that may be costing you interviews...</p>
            <a href="cv-mistakes.php" class="read-more">Read More</a>
        </div>
        <div class="blog-post">
            <h2>How to Prepare for a Virtual Interview</h2>
            <p>Virtual interviews are the new normal. Discover how to make a strong impression through your screen and stand out to recruiters...</p>
            <a href="virtual-interview.php" class="read-more">Read More</a>
        </div>
        <div class="blog-post">
            <h2>Best Job Searching Strategies in 2025</h2>
            <p>The job market is evolving. Here's how to stay ahead with smart job hunting strategies and leverage online tools effectively...</p>
            <a href="job-strategies.php" class="read-more">Read More</a>
        </div>
        <div class="blog-post">
            <h2>How to Improve Your CV</h2>
            <p>Learn how to polish your CV to make a lasting impact on recruiters. Tips for structure, content, and design...</p>
            <a href="improve-your-cv.php" class="read-more">Read More</a>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        &copy; <?= date('Y') ?> Job Recruitment System. All rights reserved.
    </footer>
</body>
</html>
