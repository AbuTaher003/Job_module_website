<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'job_seeker') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['name'] ?? '';
$user_email = $_SESSION['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = $_POST['job_id'];
    $applicant_name = $_POST['applicant_name'];
    $applicant_email = $_POST['applicant_email'];
    $status = 'Pending';
    $applied_at = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO applications (job_id, applicant_id, applicant_name, applicant_email, status, applied_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $job_id, $user_id, $applicant_name, $applicant_email, $status, $applied_at);

    if ($stmt->execute()) {
        echo "<p>✅ Application submitted successfully. <a href='job_seeker_dashboard.php'>Go back</a></p>";
    } else {
        echo "<p>❌ Failed to apply. Please try again.</p>";
    }

    $stmt->close();
    $conn->close();
    exit;
}

// GET method: show the form
if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Apply for Job</title>
        <style>
            body { font-family: Arial; margin: 40px; }
            form { max-width: 400px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 8px; }
            label { display: block; margin-top: 15px; }
            input[type="text"], input[type="email"] {
                width: 100%; padding: 8px; box-sizing: border-box;
            }
            button { margin-top: 20px; padding: 10px 20px; cursor: pointer; }
        </style>
    </head>
    <body>
        <h2>Apply for Job</h2>
        <form method="POST">
            <input type="hidden" name="job_id" value="<?= htmlspecialchars($job_id) ?>">
            
            <label for="applicant_name">Name:</label>
            <input type="text" name="applicant_name" id="applicant_name" value="<?= htmlspecialchars($user_name) ?>" required>

            <label for="applicant_email">Email:</label>
            <input type="email" name="applicant_email" id="applicant_email" value="<?= htmlspecialchars($user_email) ?>" required>

            <button type="submit">Submit Application</button>
        </form>
    </body>
    </html>

<?php
} else {
    echo "❌ Invalid request. No job ID provided.";
}
?>
