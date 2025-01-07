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
    <title>Main Page</title>
    <meta charset="UTF-8"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@700&display=swap" rel="stylesheet">
    <style>
        /* General Page Styles */
        body {
            background-color: #faf5ef;
            font-family: "Raleway", sans-serif; 
            margin: 0;
            padding: 0;
        }

        /* Header Styles */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0px 40px;
            background-color: #fff;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            width: 150px;
            height: auto;
        }

        .links {
            display: flex;
            gap: 30px;
        }

        .links a {
            text-decoration: none;
            color: #000;
            font-size: 16px;
            font-weight: bold;
        }

        .links a:hover {
            color: #555;
        }

        /* Main Section Styles */
        .main {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: calc(100vh - 150px); /* Subtract header height */
            text-align: center;
        }

        .content h1 {
            font-size: 60px;
            color: #000;
            margin-bottom: 80px;
        }

        /* Search Bar Styles */
        .search-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            background-color: #fff;
            padding: 15px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-container input, select {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 20px;
            font-size: 14px;
            outline: none;
        }

        #prog {
            width: 500px; 
        }   

        .search-container button {
            background-color: #1E4DB7;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            border-radius: 20px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #163D8B;
        }

    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="logo">
            <img src="unitenlogo.png" alt="University Logo">
            <h2 style="margin: 0; color: #1E4DB7;">ONLINE TUTORING SYSTEM</h2>
        </div>
        <nav class="links">
            <a href="mainstud.php">Home</a>
            <a href="tutreg.php">Becoming a Tutor</a>
            <a href="logout.php">Logout</a> <!-- Added logout link -->
        </nav>
    </header>

    <!-- Main Section -->
    <main class="main">
        <div class="content">
            <h1>Begin Your<br> Learning <br>Journey Now!</h1>
            <form action="studsearch.php" method="get">
                <div class="search-container">
                    <select id="prog" name="prog" required>
                        <option value="" disabled selected>Programme</option>

                        <!-- Foundation Level -->
                        <option value="Foundation in Engineering">Foundation in Engineering</option>
                        <option value="Foundation in Computer Science">Foundation in Computer Science</option>
                        <option value="Foundation in Information Technology">Foundation in Information Technology</option>
                        <option value="Foundation in Management">Foundation in Management</option>
                        <option value="Foundation in Accounting">Foundation in Accounting</option>
                        <option value="Foundation in Business Administration">Foundation in Business Administration</option>
                        <option value="Tahfiz UNITEN">Tahfiz UNITEN</option>

                        <!-- Diploma Level -->
                        <option value="Diploma in Mechanical Engineering">Diploma in Mechanical Engineering</option>
                        <option value="Diploma in Electrical Engineering">Diploma in Electrical Engineering</option>
                        <option value="Diploma in Computer Science">Diploma in Computer Science</option>
                        <option value="Diploma of Accountancy">Diploma of Accountancy</option>
                        <option value="Diploma in Business Studies">Diploma in Business Studies</option>
                        <option value="Diploma in Digital Business">Diploma in Digital Business</option>
                        <option value="Diploma in Financial Technology">Diploma in Financial Technology</option>

                        <!-- Bachelor's Level -->
                        <option value="Bachelor of Electrical and Electronics Engineering (Hons)">Bachelor of Electrical and Electronics Engineering (Hons)</option>
                        <option value="Bachelor of Computer Science (Systems and Networking) (Hons)">Bachelor of Computer Science (Systems and Networking) (Hons)</option>
                        <option value="Bachelor in Software Engineering (Honours)">Bachelor in Software Engineering (Honours)</option>
                        <option value="Bachelor of Computer Science (Cyber Security) (Honours)">Bachelor of Computer Science (Cyber Security) (Honours)</option>
                        <option value="Bachelor in Information Systems (Business Analytics) (Honours)">Bachelor in Information Systems (Business Analytics) (Honours)</option>
                    </select>
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
