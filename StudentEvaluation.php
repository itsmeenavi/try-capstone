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
                <li class="active">
                    <a>
                    <i class="material-symbols-outlined">two_pager</i>
                    <span>Evaluation</span>
                    </a>
                </li>
                <li>
                    <a href="StudentFeedback.php">
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
                    <?php echo htmlspecialchars($professorName); ?> &nbsp; ▼
                </button>
                <div class="dropdown-content2">
                    <a id="top2" href="#" onclick="openPopup()">Manage Account</a>
                    <a id="middle2" href="logout.php" onclick="confirmLogout(event)">Logout</a>
                </div>
            </div>
        </div>
</div>

        <div class="card--containerstudent">
            <h3 class="main--title">LIST OF PROFESSORS THIS SEMESTER</h3>
            <div class="card--wrapperstudentEvaluation">
            <div class="question">
        <span class="question-title">1. How well does the professor explain the subject matter?</span>
        <div class="choices">
            <input type="radio" name="q1" id="q1_choice1">&nbsp;Very Satisfied
            <input type="radio" name="q1" id="q1_choice2">&nbsp;Satisfied
            <input type="radio" name="q1" id="q1_choice3">&nbsp;Neutral
            <input type="radio" name="q1" id="q1_choice4">&nbsp;Dissatisfied
            <input type="radio" name="q1" id="q1_choice5">&nbsp;Very Dissatisfied
        </div>
    </div>

    <!-- Question 2 -->
    <div class="question">
        <span class="question-title">2. How effectively does the professor use examples and illustrations?</span>
        <div class="choices">
            <input type="radio" name="q2" id="q2_choice1">&nbsp;Excellent
            <input type="radio" name="q2" id="q2_choice2">&nbsp;Good
            <input type="radio" name="q2" id="q2_choice3">&nbsp;Average
            <input type="radio" name="q2" id="q2_choice4">&nbsp;Poor
            <input type="radio" name="q2" id="q2_choice5">&nbsp;Very Poor
        </div>
    </div>

    <!-- Question 3 -->
    <div class="question">
        <span class="question-title">3. Does the professor encourage student participation and discussion?</span>
        <div class="choices">
            <input type="radio" name="q3" id="q3_choice1">&nbsp;Very Likely
            <input type="radio" name="q3" id="q3_choice2">&nbsp;Likely
            <input type="radio" name="q3" id="q3_choice3">&nbsp;Neutral
            <input type="radio" name="q3" id="q3_choice4">&nbsp;Unlikely
            <input type="radio" name="q3" id="q3_choice5">&nbsp;Very Unlikely
        </div>
    </div>

    <!-- Question 4 -->
    <div class="question">
        <span class="question-title">4. Is the professor punctual and consistent in starting classes?</span>
        <div class="choices">
            <input type="radio" name="q4" id="q4_choice1">&nbsp;Very Easy
            <input type="radio" name="q4" id="q4_choice2">&nbsp;Easy
            <input type="radio" name="q4" id="q4_choice3">&nbsp;Neutral
            <input type="radio" name="q4" id="q4_choice4">&nbsp;Difficult
            <input type="radio" name="q4" id="q4_choice5">&nbsp;Very Difficult
        </div>
    </div>

    <!-- Question 5 -->
    <div class="question">
        <span class="question-title">5. How clear are the professor's grading policies and expectations?</span>
        <div class="choices">
            <input type="radio" name="q5" id="q5_choice1">&nbsp;Excellent
            <input type="radio" name="q5" id="q5_choice2">&nbsp;Good
            <input type="radio" name="q5" id="q5_choice3">&nbsp;Average
            <input type="radio" name="q5" id="q5_choice4">&nbsp;Poor
            <input type="radio" name="q5" id="q5_choice5">&nbsp;Very Poor
        </div>
    </div>
    <button class="feedback-button">Submit</button>
        </div>
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
                    id="username"
                />
                <label for="username">Change Username</label>
            </div>
            <div class="input-field">
                <input
                    required=""
                    autocomplete="off"
                    type="email"
                    name="email"
                    id="email"
                />
                <label for="Password">Change Password</label>
            </div>
            <div class="input-field">
                <input
                    required=""
                    autocomplete="off"
                    type="password"
                    name="text"
                    id="password"
                />
                <label for="ConfirmPass">Confirm Password</label>
            </div>
            <div class="input-field">
                <input
                    required=""
                    autocomplete="off"
                    type="password"
                    name="text"
                    id="password"
                />
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