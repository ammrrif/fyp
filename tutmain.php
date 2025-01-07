<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) {
    header('Location: Login.html');
    exit();
}

// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Main Page</title>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="tutmain.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">
            <img src="unitenlogo.png" alt="University Logo">
            <h2 style="margin: 0; color: #1E4DB7;">ONLINE TUTORING SYSTEM</h2>
        </div>
        <nav class="links">
            <a href="find-tutors.html">Find Tutors</a>
            <a href="becoming-a-tutor.html">Becoming a Tutor</a>
            <a href="logout.php">Logout</a> <!-- Added logout link -->
        </nav>
    </header>

    <!-- Main Content with Sidebar -->
    <div class="container">
        <!-- Left Sidebar -->
        <aside class="sidebar">
            <h3>Tutor Dashboard</h3>
            <ul>
                <li><a href="profile.php">Display Profile</a></li>
                <li><a href="session.php">Manage Sessions</a></li>
                <li><a href="student-reviews.html">Student Reviews</a></li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="content">
            <h1>Welcome, [Tutor's Name]</h1>
            <p>Here, you can manage your profile, sessions, and more.</p>
        </main>
    </div>
</body>
</html>
