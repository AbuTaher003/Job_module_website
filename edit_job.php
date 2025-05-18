<?php
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "recruiter") {
    header("Location: login.php");
    exit();
}

$recruiter_id = $_SESSION["user_id"];
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$message = "";
$message_type = "";

// Fetch job info
$stmt = $conn->prepare("SELECT * FROM job WHERE id = ? AND recruiter_id = ?");
$stmt->bind_param("ii", $job_id, $recruiter_id);
$stmt->execute();
$result = $stmt->get_result();
$job = $result->fetch_assoc();
$stmt->close();

if (!$job) {
    die("Job not found or access denied.");
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $company = trim($_POST["company"]);
    $description = trim($_POST["description"]);

    $stmt = $conn->prepare("UPDATE job SET title = ?, company = ?, description = ? WHERE id = ? AND recruiter_id = ?");
    $stmt->bind_param("sssii", $title, $company, $description, $job_id, $recruiter_id);

    if ($stmt->execute()) {
        header("Location: recruiter_dashboard.php");
        exit();
    } else {
        $message = "Failed to update job.";
        $message_type = "error";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Job</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: url('recru.jpg') no-repeat center center/cover;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 90%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .container:hover {
            transform: scale(1.015);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.25);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #003049;
            font-size: 28px;
        }

        input, textarea {
            width: 100%;
            padding: 14px 16px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: 2px solid #ccc;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background: #f9f9f9;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.3);
            background: #fff;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        button {
            width: 100%;
            padding: 15px;
            font-size: 17px;
            font-weight: 600;
            background: linear-gradient(45deg, #007bff, #00d4ff);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px #00d4ffcc;
        }

        .alert {
            text-align: center;
            padding: 12px;
            background-color: #dc3545;
            color: white;
            font-weight: 600;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .back-link {
            display: block;
            margin-top: 25px;
            text-align: center;
            color: #007bff;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .back-link:hover {
            color: #0056b3;
        }

        @media (max-width: 600px) {
            .container {
                padding: 25px;
            }
            h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Edit Job</h2>

        <?php if (!empty($message)): ?>
            <div class="alert"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="post">
            <input type="text" name="title" value="<?php echo htmlspecialchars($job['title']); ?>" required />
            <input type="text" name="company" value="<?php echo htmlspecialchars($job['company']); ?>" required />
            <textarea name="description" required><?php echo htmlspecialchars($job['description']); ?></textarea>
            <button type="submit">Update Job</button>
        </form>

        <a class="back-link" href="recruiter_dashboard.php">← Back to Dashboard</a>
    </div>

</body>
</html>
