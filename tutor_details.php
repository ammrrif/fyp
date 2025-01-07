<?php
// Database connection
$servername = "localhost"; // Database server, replace with your server if needed
$username = "root";        // Database username, replace with your username if needed
$password = "";            // Database password, replace with your password if needed
$dbname = "fyp";           // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get tutor details from query parameters
$tutor_name = isset($_GET['tutor_name']) ? $_GET['tutor_name'] : 'N/A';
$subject = isset($_GET['subject']) ? $_GET['subject'] : 'N/A';
$session_date = isset($_GET['session_date']) ? $_GET['session_date'] : 'N/A'; // Date format: YYYY-MM-DD

// Fetch tutor sessions from the database
$sql = "SELECT * FROM tutor_sessions WHERE tutor_name = '$tutor_name' AND subject = '$subject'";
$result = $conn->query($sql);

// Extract session year, month, and day
$sessionDateObj = DateTime::createFromFormat('Y-m-d', $session_date);
$sessionMonth = $sessionDateObj->format('m');
$sessionYear = $sessionDateObj->format('Y');
$sessionDay = $sessionDateObj->format('d');

// Get the first day of the month and the number of days in the month
$firstDayOfMonth = strtotime("$sessionYear-$sessionMonth-01");
$lastDayOfMonth = strtotime("last day of $sessionMonth $sessionYear");
$daysInMonth = date('t', $firstDayOfMonth);
$firstDayOfWeek = date('w', $firstDayOfMonth); // Get the day of the week of the first day (0=Sunday, 6=Saturday)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Details - Online Tutoring System</title>
    <link rel="stylesheet" href="tutordetails.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">
            <img src="unitenlogo.png" alt="University Logo">
            <h2 style="margin: 0; color: #1E4DB7;">ONLINE TUTORING SYSTEM</h2>
        </div>
        <nav class="links">
            <a href="main.html">Home</a>
            <a href="tutreg.html">Becoming A Tutor</a>
            <a href="logout.php">Logout</a> <!-- Added logout link -->
        </nav>
    </header>

    <!-- Tutor Details Section -->
    <section class="tutor-details">
        <h1 class="tutor-title">Tutor Details</h1> <!-- Header for Tutor Details -->

        <div class="tutor-info">
            <div class="tutor-description">
                <h2><?php echo $tutor_name; ?></h2>
                <p><strong>Subject:</strong> <?php echo $subject; ?></p>
                <p><strong>Session Date:</strong> <?php echo $session_date; ?></p>
            </div>
        </div>
    </section>

    <!-- Availability Calendar Section -->
    <section class="availability-calendar">
        <h2>Availability Calendar</h2>
        <div class="calendar">
            <div class="calendar-header">
                <span class="prev-month">&#8249;</span>
                <span class="month-year"><?php echo date('F Y', strtotime("$sessionYear-$sessionMonth-01")); ?></span>
                <span class="next-month">&#8250;</span>
            </div>
            <div class="calendar-body">
                
                <!-- Empty slots before the first day of the month -->
                <?php for ($i = 0; $i < $firstDayOfWeek; $i++) { echo '<div class="day empty"></div>'; } ?>

                <!-- Days of the month -->
                <?php
                // Fetch all session dates for the tutor
                $sessionDates = [];
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $sessionDates[] = date('d', strtotime($row['session_date']));
                    }
                }

                // Loop through each day of the month
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    // Check if the current day matches a session date
                    if (in_array($day, $sessionDates)) {
                        echo "<div class='day available'>$day</div>";
                    } else {
                        echo "<div class='day unavailable'>$day</div>";
                    }
                }
                ?>
            </div>
        </div>

        <!-- Book Now Button Section (Positioned at bottom right) -->
        <section class="book-now">
        <a href="book_session.php?session_date=<?php echo $session_date; ?>&tutor_name=<?php echo urlencode($tutor_name); ?>&subject=<?php echo urlencode($subject); ?>" class="book-btn">Book Now</a>


    </section>
    </section>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
