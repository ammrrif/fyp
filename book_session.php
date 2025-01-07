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

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fyp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get parameters from the URL
$tutor_name = isset($_GET['tutor_name']) ? $_GET['tutor_name'] : '';
$subject = isset($_GET['subject']) ? $_GET['subject'] : '';
$session_date = isset($_GET['session_date']) ? $_GET['session_date'] : '';
$student_id = isset($_SESSION['student_id']) ? $_SESSION['student_id'] : ''; // Assuming student is logged in

// Get the tutor's ID based on tutor_name
$tutor_query = "SELECT ID FROM tutor WHERE name = ?";
$stmt = $conn->prepare($tutor_query);
$stmt->bind_param("s", $tutor_name);
$stmt->execute();
$tutor_result = $stmt->get_result();
$tutor = $tutor_result->fetch_assoc();
$tutor_id = $tutor['ID'];

// Calculate the session date and time (this can be adjusted as needed)
$session_datetime = $session_date . " 10:00:00"; // Assuming session time is at 10:00 AM (you can adjust this)

// Prepare and execute the INSERT query
$booking_query = "INSERT INTO bookings (StudentID, TutorID, SessionDateTime, Subject) 
                  VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($booking_query);
$stmt->bind_param("ssss", $student_id, $tutor_id, $session_datetime, $subject);

if ($stmt->execute()) {
    // Display success message
    echo "<script>alert('Booking successful!');</script>";
    
    // Redirect to studsearch.php after displaying the message
    echo "<script>window.location.href = 'studsearch.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
