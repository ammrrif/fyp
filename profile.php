<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['UserID'])) { // Use 'UserID' as set in loginverify.php
    header('Location: Login.html'); // Redirect to login page if not logged in
    exit();
}

// Prevent caching
header("Cache-Control: no-cache, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

$user_id = $_SESSION['UserID']; // Get the UserID from session

// Database connection details
$host = "localhost";
$user = "root";
$pass = "";  // Enter your DB password if any
$db = "fyp";  // Database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current profile data
$query = "SELECT * FROM tutor WHERE ID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$tutor_data = $result->fetch_assoc();

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap" rel="stylesheet">
    <title>Profile</title>
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
            <h2>Your Profile</h2>
            <table>
                <tr>
                    <td>Name:</td>
                    <td><?php echo htmlspecialchars($tutor_data['Name']); ?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?php echo htmlspecialchars($tutor_data['Email']); ?></td>
                </tr>
                <tr>
                    <td>Programme:</td>
                    <td><?php echo htmlspecialchars($tutor_data['Programme']); ?></td>
                </tr>
                <tr>
                    <td>Hourly Rate:</td>
                    <td><?php echo htmlspecialchars($tutor_data['Rate']); ?></td>
                </tr>
                <tr>
                    <td>Short Bio:</td>
                    <td><?php echo htmlspecialchars($tutor_data['Bio']); ?></td>
                </tr>
                <tr>
                    <td>Profile Picture:</td>
                    <td>
                        <img src="uploads/<?php echo htmlspecialchars($tutor_data['Picture']); ?>" alt="Profile Picture" width="100">
                    </td>
                </tr>
            </table>

            <br />
            <a href="edit_profile.php"><button>Edit Profile</button></a>
        </main>
    </div>
</body>
</html>