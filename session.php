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

// Database connection details
$host = 'localhost';
$dbname = 'fyp';
$user = 'root';
$password = '';

try {
    // Connect to the database
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Initialize variables
    $message = '';
    $sessions = [];
    $tutor_name = '';

    // Fetch the tutor's name using the UserID from the session
    $user_id = $_SESSION['UserID'];
    $stmt = $conn->prepare("SELECT Name FROM tutor WHERE ID = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $tutor = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($tutor) {
        $tutor_name = $tutor['Name'];
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['delete_session'])) {
            $session_id = $_POST['delete_session_id'];
            $stmt = $conn->prepare("DELETE FROM tutor_sessions WHERE session_id = :session_id");
            $stmt->bindParam(':session_id', $session_id);
            if ($stmt->execute()) {
                $message = "Session deleted successfully!";
            } else {
                $message = "Error deleting session. Please try again.";
            }
            header("Location: session.php");
            exit;
        } else {
            $subject = $_POST['subject'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            // Insert data into the database
            $stmt = $conn->prepare("INSERT INTO tutor_sessions (`tutor_name`, `subject`, `session_date`, `session_time`) VALUES (:tutor_name, :subject, :date, :time)");
            $stmt->bindParam(':tutor_name', $tutor_name);
            $stmt->bindParam(':subject', $subject);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':time', $time);

            if ($stmt->execute()) {
                // Set success message and redirect to avoid re-submitting
                $message = "Session created successfully!";
                header("Location: session.php");
                exit; // Stop the script to ensure redirection happens
            } else {
                $message = "Error creating session. Please try again.";
            }
        }
    }

    // Fetch sessions for the current tutor
    $stmt = $conn->prepare("SELECT `session_id`, `tutor_name`, `subject`, `session_date`, `session_time` FROM tutor_sessions WHERE `tutor_name` = :tutor_name");
    $stmt->bindParam(':tutor_name', $tutor_name);
    $stmt->execute();
    $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
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
    <title>Manage Sessions</title>
    <link rel="stylesheet" href="session.css">
</head>
<body>
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

    <div class="container">
        <aside class="sidebar">
            <h3>Tutor Dashboard</h3>
            <ul>
                <li><a href="profile.php">Display Profile</a></li>
                <li><a href="session.php">Manage Sessions</a></li>
                <li><a href="student-reviews.html">Student Reviews</a></li>
            </ul>
        </aside>

        <main>
            <h1>Create a New Session</h1>
            <?php if ($message): ?>
                <p class="message"><?= htmlspecialchars($message) ?></p>
            <?php endif; ?>

            <form action="session.php" method="POST">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" placeholder="Enter subject" required>

                <label for="date">Preferred Date:</label>
                <input type="date" id="date" name="date" required>

                <label for="time">Preferred Time:</label>
                <input type="time" id="time" name="time" required>

                <button type="submit">Create Session</button>
            </form>

            <?php if (!empty($sessions)): ?>
                <h2>Your Sessions</h2>
                <table>
                    <tr>
                        <th>Tutor Name</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                    </tr>
                    <?php foreach ($sessions as $session): ?>
                        <tr>
                            <td><?= htmlspecialchars($session['tutor_name']) ?></td>
                            <td><?= htmlspecialchars($session['subject']) ?></td>
                            <td><?= htmlspecialchars($session['session_date']) ?></td>
                            <td><?= htmlspecialchars($session['session_time']) ?></td>
                            <td>
                                <form class="delete-form" action="session.php" method="POST">
                                    <input type="hidden" name="delete_session_id" value="<?= htmlspecialchars($session['session_id']) ?>">
                                    <button type="submit" name="delete_session" onclick="return confirm('Are you sure you want to delete this session?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                    <p>No sessions found for the entered name.</p>
                <?php endif; ?>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>