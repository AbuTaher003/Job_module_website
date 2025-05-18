<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "admin") {
    header("Location: login.php");
    exit();
}
?>
<h2>Admin Dashboard</h2>
<a href="logout.php">Logout</a>
<a href="index.php" style="margin-left: 10px;">Home</a>
