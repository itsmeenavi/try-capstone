<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    echo "<script>alert('You must be logged in to view this page.'); window.location.href = 'index.php';</script>";
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];

// Database connection
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "fes";

// Create connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and bind
$stmt = $conn->prepare("SELECT Fullname FROM tblusers WHERE username = ? AND role = ?");
$stmt->bind_param("ss", $username, $role);

// Execute the query
$stmt->execute();
$stmt->bind_result($fullname);
$stmt->fetch();

// Close connection
$stmt->close();
$conn->close();


// Check if the form has been submitted
$sentimentResult = null; // Initialize variable to store sentiment result
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_feedback'])) {
    // Get the feedback text from the form
    $feedbackText = $_POST['feedback_text'];

    // Escape the feedback text to prevent command injection
    $escapedFeedback = escapeshellarg($feedbackText);

    // Construct the command to call the Python script
    $command = "python sentiment_analysis.py $escapedFeedback";

    // Execute the command and capture the output
    $output = shell_exec($command);

    // Decode the JSON output
    $sentimentResult = json_decode($output, true);

    // Handle cases where the output is not valid JSON
    if ($sentimentResult === null) {
        $error = "Error processing sentiment analysis.";
    }
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Evaluation System</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="Dashboard--body">
    <div class="sidebar">
        <div class="logo2">
            <ul class="menu">
                <Span class="admin"><img src="images/LoaLogo.png"></Span>
                <hr>
                <li>
                    <a href="StudentDashboard.php">
                        <i class="material-symbols-outlined">Guardian</i>
                        <span>Professors</span>
                    </a>
                </li>
                <li>
                    <a href="StudentEvaluation.php">
                        <i class="material-symbols-outlined">two_pager</i>
                        <span>Evaluation</span>
                    </a>
                </li>
                <li class="active">
                    <a>
                        <i class="material-symbols-outlined">comment</i>
                        <span>Feedback</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
            </div>
            <div class="user--info">
                <div class="paste-button2">
                    <button class="button2">
                        <i class="material-symbols-outlined">account_circle</i>
                        <?php echo htmlspecialchars($fullname); ?> &nbsp; ▼
                    </button>
                    <div class="dropdown-content2">
                        <a id="top2" href="#" onclick="openPopup()">Manage Account</a>
                        <a id="middle2" href="logout.php" onclick="confirmLogout(event)">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card--containerstudentfeedback">
            <h3 class="main--title">LIST OF PROFESSORS THIS SEMESTER</h3>
            <div class="card--wrapperstudentFeedback">
                <form method="post" action="StudentFeedback.php">
                    <textarea name="feedback_text" class="feedback-input" placeholder="Feedback" rows="4" cols="50"></textarea>
                    <button type="submit" name="submit_feedback" class="feedback-button">Submit</button>
                </form>
                
                <?php if (isset($sentimentResult)): ?>
                    <div class="sentiment-result">
                        <h4>Sentiment Analysis Result:</h4>
                        <p>Sentiment: <strong><?php echo htmlspecialchars($sentimentResult['sentiment']); ?></strong></p>
                        <p>Polarity: <?php echo htmlspecialchars($sentimentResult['polarity']); ?></p>
                        <p>Subjectivity: <?php echo htmlspecialchars($sentimentResult['subjectivity']); ?></p>
                    </div>
                <?php elseif (isset($error)): ?>
                    <div class="error-message">
                        <p><?php echo htmlspecialchars($error); ?></p>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>
    <div class="main--content">
        <div class="header--wrapper">
            <div class="header--title">
                <h1>FACULTY EVALUATION<h1>
            </div>
            <div class="user--info">
                <div class="paste-button2">
                    <button class="button2">
                        <i class="material-symbols-outlined">face_6</i>
                        <?php echo htmlspecialchars($fullname); ?> &nbsp; ▼
                    </button>
                    <div class="dropdown-content2">
                        <a id="top2" href="#" onclick="openPopup()">Manage Account</a>
                        <a id="middle2" href="logout.php" onclick="confirmLogout(event)">Logout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" id="popup">
            <div class="heading">Manage Account</div>
            <form class="form" action="">
                <div class="input-field">
                    <input
                        required=""
                        autocomplete="off"
                        type="text"
                        name="text"
                        id="username" />
                    <label for="username">Change Username</label>
                </div>
                <div class="input-field">
                    <input
                        required=""
                        autocomplete="off"
                        type="email"
                        name="email"
                        id="email" />
                    <label for="Password">Change Password</label>
                </div>
                <div class="input-field">
                    <input
                        required=""
                        autocomplete="off"
                        type="password"
                        name="text"
                        id="password" />
                    <label for="ConfirmPass">Confirm Password</label>
                </div>
                <div class="input-field">
                    <input
                        required=""
                        autocomplete="off"
                        type="password"
                        name="text"
                        id="password" />
                    <label for="Fullname">Change Full name</label>
                </div>
                <div class="btn-container">
                    <button class="btn" id="Savebtn">Save</button>
                    <button class="btn" id="Cancelbtn" onclick="closePopup()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('middle2').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the default link behavior
                var userConfirmation = confirm("Do you want to logout?");
                if (userConfirmation) {
                    window.location.href = "logout.php";
                }
            });
        });

        let popup = document.getElementById("popup");
        let manageAccountLink = document.getElementById("top2");
        let cancelButton = document.getElementById("Cancelbtn");

        function openPopup() {
            popup.classList.add("open-popup");
        }

        function closePopup() {
            popup.classList.remove("open-popup");
        }

        manageAccountLink.addEventListener("click", function(event) {
            event.preventDefault();
            openPopup();
        });

        cancelButton.addEventListener("click", function() {
            closePopup();
        });

        function confirmLogout(event) {
            event.preventDefault(); // Prevent the default link action
            if (confirm("Are you sure you want to log out?")) {
                // If user clicks "Yes", proceed with logout
                window.location.href = "logout.php"; // Redirect to the PHP logout script
            }
        }
    </script>
</body>

</html>