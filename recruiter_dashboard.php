<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "recruiter") {
    header("Location: login.php");
    exit();
}

$message = "";
$message_type = "";

// Delete job
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $recruiter_id = $_SESSION["user_id"];
    $stmt = $conn->prepare("DELETE FROM job WHERE id = ? AND recruiter_id = ?");
    $stmt->bind_param("ii", $delete_id, $recruiter_id);
    if ($stmt->execute()) {
        $message = "Job deleted successfully!";
        $message_type = "success";
    } else {
        $message = "Error deleting job!";
        $message_type = "error";
    }
    $stmt->close();
}

// Accept or reject application
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"])) {
    $application_id = intval($_POST["application_id"]);
    $action = $_POST["action"]; // accept or reject
    $status = $action == "accept" ? "Accepted" : "Rejected";

    $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $application_id);
    $stmt->execute();
    $stmt->close();
}

// Post a job
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["title"]) && !isset($_POST["action"])) {
    $title = trim($_POST["title"]);
    $company = trim($_POST["company"]);
    $description = trim($_POST["description"]);
    $recruiter_id = $_SESSION["user_id"];

    $sql = "INSERT INTO job (recruiter_id, title, company, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $recruiter_id, $title, $company, $description);
    if ($stmt->execute()) {
        $message = "Job posted successfully!";
        $message_type = "success";
    } else {
        $message = "Error posting job!";
        $message_type = "error";
    }
    $stmt->close();
}

// Fetch posted jobs
$jobs = [];
$stmt = $conn->prepare("SELECT * FROM job WHERE recruiter_id = ? ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$jobs = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch applications grouped by job
$job_applications = [];
foreach ($jobs as $job) {
    $stmt = $conn->prepare("SELECT * FROM applications WHERE job_id = ?");
    $stmt->bind_param("i", $job['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $job_applications[$job['id']] = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Recruiter Dashboard</title>
    <link rel="stylesheet" href="recruiter_dashboard.css" />
</head>
<body>

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

<!-- Hamburger menu -->
<div class="hamburger-menu" id="hamburgerMenu" title="Menu" tabindex="0" aria-label="Toggle menu">
    <span></span>
    <span></span>
    <span></span>
</div>

<!-- Dropdown menu -->
<div class="menu-dropdown" id="menuDropdown" aria-hidden="true">
    <button type="button" onclick="openModal('jobsModal')">Posted Jobs</button>
    <button type="button" onclick="openModal('applicantsModal')">Applicants</button>
</div>

<div class="dashboard-container">
    <h2>Recruiter Dashboard</h2>

    <form method="post" autocomplete="off" class="job-post-form">
        <input type="text" name="title" placeholder="Job Title" required />
        <input type="text" name="company" placeholder="Company Name" required />
        <textarea name="description" placeholder="Job Description" rows="5" required></textarea>
        <button type="submit">Post Job</button>
    </form>

    <div class="alert <?php echo $message_type; ?>"><?php echo htmlspecialchars($message); ?></div>
</div>

<!-- Posted Jobs Modal -->
<div class="modal-bg" id="jobsModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="jobsModalLabel">
    <div class="modal">
        <button class="close-btn" onclick="closeModal('jobsModal')" aria-label="Close Posted Jobs">&times;</button>
        <h3 id="jobsModalLabel">Posted Jobs</h3>
        <div class="modal-content">
            <div class="job-list">
                <?php if (count($jobs) > 0): ?>
                    <?php foreach ($jobs as $job): ?>
                        <div class="job-item">
                            <div class="job-title"><?php echo htmlspecialchars($job['title']); ?></div>
                            <div class="job-company">Company: <?php echo htmlspecialchars($job['company']); ?></div>
                            <div class="job-description"><?php echo nl2br(htmlspecialchars($job['description'])); ?></div>
                            <div class="job-actions">
                                <a class="edit" href="edit_job.php?id=<?php echo $job['id']; ?>">Edit</a>
                                <a class="delete" href="?delete=<?php echo $job['id']; ?>" onclick="return confirm('Are you sure you want to delete this job?');">Delete</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No jobs posted yet.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Applicants Modal -->
<div class="modal-bg" id="applicantsModal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="applicantsModalLabel">
    <div class="modal">
        <button class="close-btn" onclick="closeModal('applicantsModal')" aria-label="Close Applicants">&times;</button>
        <h3 id="applicantsModalLabel">Applicants for Your Jobs</h3>
        <div class="modal-content">
            <?php foreach ($jobs as $job): ?>
                <div class="job-item">
                    <div class="job-title"><?php echo htmlspecialchars($job['title']); ?> (<?php echo count($job_applications[$job['id']]); ?> applicants)</div>
                    <?php if (count($job_applications[$job['id']]) > 0): ?>
                        <?php foreach ($job_applications[$job['id']] as $app): ?>
                            <div class="applicant-box">
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($app['applicant_name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($app['applicant_email']); ?></p>
                                <p><strong>Resume:</strong> <a href="<?php echo htmlspecialchars($app['resume']); ?>" target="_blank">View Resume</a></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($app['status'] ?: "Pending"); ?></p>

                                <?php if ($app['status'] != "Accepted" && $app['status'] != "Rejected"): ?>
                                    <form method="post" style="margin-top: 10px;">
                                        <input type="hidden" name="application_id" value="<?php echo $app['id']; ?>">
                                        <button type="submit" name="action" value="accept">Accept</button>
                                        <button type="submit" name="action" value="reject">Reject</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No applicants yet for this job.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    const hamburgerMenu = document.getElementById('hamburgerMenu');
    const menuDropdown = document.getElementById('menuDropdown');

    hamburgerMenu.addEventListener('click', () => {
        hamburgerMenu.classList.toggle('open');
        if (menuDropdown.style.display === 'flex') {
            menuDropdown.style.display = 'none';
            menuDropdown.setAttribute('aria-hidden', 'true');
        } else {
            menuDropdown.style.display = 'flex';
            menuDropdown.setAttribute('aria-hidden', 'false');
        }
    });

    // Close dropdown if clicked outside
    window.addEventListener('click', e => {
        if (!hamburgerMenu.contains(e.target) && !menuDropdown.contains(e.target)) {
            hamburgerMenu.classList.remove('open');
            menuDropdown.style.display = 'none';
            menuDropdown.setAttribute('aria-hidden', 'true');
        }
    });

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
        hamburgerMenu.classList.remove('open');
        menuDropdown.style.display = 'none';
        menuDropdown.setAttribute('aria-hidden', 'true');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>

</body>
</html>
