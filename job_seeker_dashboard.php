<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Available jobs
$sql_jobs = "SELECT * FROM job ORDER BY created_at DESC";
$result_jobs = $conn->query($sql_jobs);

// My Applications
$sql_apps = "SELECT a.*, j.title, j.company 
             FROM applications a 
             JOIN job j ON a.job_id = j.id 
             WHERE a.applicant_id = ? 
             ORDER BY a.applied_at DESC";
$stmt = $conn->prepare($sql_apps);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$applications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Job Seeker Dashboard</title>
  <link rel="stylesheet" href="job_seeker_dashboard.css" />
</head>
<body>

  <div class="sidebar">
    <h2>Dashboard</h2>
    <a class="nav-link active" data-section="available-jobs">Available Jobs</a>
    <a class="nav-link" data-section="my-applications">My Applications</a>
    <a class="nav-link" data-section="saved-jobs">Saved Jobs</a>
    <a class="nav-link" data-section="profile-settings">Profile Settings</a>
  </div>

  <div class="main-content">
    <div class="top-bar">
      <span>
        <span class="hamburger" id="hamburger">&#9776;</span>
        Hello, Welcome to your dashboard!
      </span>
      <a href="logout.php">Logout</a>
    </div>

    <!-- Available Jobs Section -->
    <div id="available-jobs" class="section active">
      <h3>Available Jobs</h3>
      <table>
        <thead>
          <tr>
            <th>Job Title</th>
            <th>Company</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result_jobs && $result_jobs->num_rows > 0): ?>
            <?php while($row = $result_jobs->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= htmlspecialchars($row['company']) ?></td>
                <td><a href="apply.php?job_id=<?= $row['id'] ?>" class="apply-btn">Apply Now</a></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="3">No jobs available.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- My Applications Section -->
    <div id="my-applications" class="section">
      <h3>My Applications</h3>
      <table>
        <thead>
          <tr>
            <th>Job Title</th>
            <th>Company</th>
            <th>Applied At</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($applications && $applications->num_rows > 0): ?>
            <?php while($app = $applications->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($app['title']) ?></td>
                <td><?= htmlspecialchars($app['company']) ?></td>
                <td><?= htmlspecialchars($app['applied_at']) ?></td>
                <td><?= htmlspecialchars($app['status']) ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="4">You haven't applied to any jobs yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Saved Jobs Section -->
    <div id="saved-jobs" class="section">
      <h3>Saved Jobs</h3>
      <p>Feature coming soon.</p>
    </div>

    <!-- Profile Settings Section -->
    <div id="profile-settings" class="section profile-settings">
      <h3>Profile Settings</h3>
      <form>
        <div class="form-group">
          <label>Name</label>
          <input type="text" value="John Doe" />
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" value="john@example.com" />
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" placeholder="Enter new password" />
        </div>
        <button type="submit" class="btn-update">Update Profile</button>
      </form>
    </div>
  </div>

  <script src="job_seeker_dashboard.js"></script>
</body>
</html>
